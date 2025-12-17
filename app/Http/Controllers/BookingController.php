<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Staff;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $staffs = Staff::all();
        return view('booking.index', compact('services', 'staffs'));
    }

    // --- HÀM LƯU (ĐÃ SỬA LOGIC CHẶN TRÙNG) ---
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'staff_id'   => 'required|exists:staff,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        $service = Service::findOrFail($request->service_id);

        // 1. Tính toán thời gian Bắt đầu và Kết thúc của khách mới
        $newStartTime = Carbon::parse($request->date . ' ' . $request->start_time);
        $newEndTime   = $newStartTime->copy()->addMinutes($service->duration);

        // 2. LOGIC KIỂM TRA TRÙNG LỊCH (QUAN TRỌNG NHẤT)
        // Lịch trùng là khi: (Start cũ < End mới) VÀ (End cũ > Start mới)
        $isOverlap = Appointment::where('staff_id', $request->staff_id)
            ->whereDate('start_time', $request->date) // Chỉ check trong ngày đó
            ->where(function ($query) use ($newStartTime, $newEndTime) {
                $query->where('start_time', '<', $newEndTime)
                      ->where('end_time', '>', $newStartTime);
            })
            ->exists();

        if ($isOverlap) {
            return back()->withErrors(['error' => 'Khung giờ này đã bị trùng hoặc nhân viên đang bận phục vụ khách khác. Vui lòng chọn giờ khác!'])->withInput();
        }

        // 3. Nếu không trùng thì lưu
        Appointment::create([
            'user_id'    => Auth::id(),
            'service_id' => $request->service_id,
            'staff_id'   => $request->staff_id,
            'start_time' => $newStartTime,
            'end_time'   => $newEndTime,
            'status'     => 'pending',
        ]);

        return redirect()->route('booking.history')
            ->with('success', 'Đặt lịch thành công!');
    }

    public function history()
    {
        $appointments = Appointment::where('user_id', Auth::id())
            ->with(['service', 'staff'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.history', compact('appointments'));
    }

    // --- HÀM LẤY GIỜ RẢNH (ĐÃ SỬA ĐỂ HIỂN THỊ CHUẨN) ---
    public function getAvailableTime(Request $request)
    {
        $staffId = $request->staff_id;
        $date    = $request->date;

        // 1. Danh sách tất cả khung giờ bạn có
        $allSlots = [
            "07:30", "08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
            "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"
        ];

        // 2. Lấy danh sách các lịch ĐÃ ĐẶT của nhân viên trong ngày đó
        $appointments = Appointment::where('staff_id', $staffId)
                                   ->whereDate('start_time', $date)
                                   ->get(['start_time', 'end_time']);

        $availableSlots = [];

        // 3. Duyệt qua từng khung giờ để kiểm tra xem nó có nằm trong giờ bận không
        foreach ($allSlots as $slot) {
            // Tạo timestamp cho khung giờ đang xét (Ví dụ: 2025-12-17 08:30:00)
            $checkTime = Carbon::parse($date . ' ' . $slot);
            
            $isBusy = false;

            foreach ($appointments as $app) {
                $busyStart = Carbon::parse($app->start_time);
                $busyEnd   = Carbon::parse($app->end_time);

                // Logic: Nếu giờ đang xét >= Giờ Bắt đầu Cũ VÀ < Giờ Kết thúc Cũ
                // Ví dụ: Đã có lịch 8:00 - 10:00.
                // Xét 8:30 -> (8:30 >= 8:00 && 8:30 < 10:00) => BẬN
                if ($checkTime->gte($busyStart) && $checkTime->lt($busyEnd)) {
                    $isBusy = true;
                    break; // Đã bận rồi thì bỏ qua, không cần check lịch khác
                }
            }

            // Nếu không bận thì thêm vào danh sách rảnh
            if (!$isBusy) {
                $availableSlots[] = $slot;
            }
        }

        return response()->json($availableSlots);
    }
}