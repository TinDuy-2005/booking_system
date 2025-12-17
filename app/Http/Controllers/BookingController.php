<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Appointment; // <-- QUAN TRỌNG: Phải dùng Model này
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Bước 1: Hiển thị form chọn Dịch vụ, Nhân viên, Ngày
     * (Route: GET /booking)
     */
    public function index()
    {
        // Lấy dữ liệu để đổ vào form select
        $services = Service::all();
        $staffs = Staff::all();
        
        // Trả về view form đặt lịch (booking/index.blade.php)
        return view('booking.index', compact('services', 'staffs'));
    }

    /**
     * Bước 2: Lưu Lịch hẹn vào database
     * (Route: POST /booking)
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);
        
        // Tính toán giờ kết thúc dựa trên thời lượng dịch vụ
        $startTime = Carbon::parse($request->date . ' ' . $request->start_time);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // 2. KIỂM TRA TRÙNG LỊCH (Logic Time Slot đơn giản)
        // Tìm xem nhân viên này đã có lịch nào trùng vào giờ này chưa
        $isBooked = Appointment::where('staff_id', $request->staff_id)
            ->where('date', $request->date) // Lưu ý: Nếu DB bạn dùng start_time datetime thì đoạn này cần sửa chút, nhưng tạm thời để date nếu bạn có cột date
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '>=', $startTime)
                      ->where('start_time', '<', $endTime);
                })
                ->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('end_time', '>', $startTime)
                      ->where('end_time', '<=', $endTime);
                });
            })->exists();

        // Lưu ý: Nếu bảng appointments của bạn lưu start_time là DateTime (Y-m-d H:i:s) 
        // thì logic check trùng sẽ cần query whereBetween phức tạp hơn một chút. 
        // Nhưng để test cơ bản thì ta cứ cho lưu trước đã.

        if ($isBooked) {
            return back()->withErrors(['time' => 'Khung giờ này nhân viên đã bận. Vui lòng chọn giờ khác!'])->withInput();
        }

        // 3. Lưu vào DB
        Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'staff_id' => $request->staff_id,
            'date' => $request->date, // Nếu DB bạn có cột date
            'start_time' => $startTime, // Lưu DateTime đầy đủ
            'end_time' => $endTime,     // Lưu DateTime đầy đủ
            'status' => 'pending',
        ]);

        // 4. Chuyển hướng về Dashboard Admin để xem kết quả
        return redirect()->route('dashboard')->with('success', 'Đặt lịch thành công!');
    }
}