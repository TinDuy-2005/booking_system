<?php
// app/Http/Controllers/Admin/StaffScheduleController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffSchedule;
use Illuminate\Http\Request;

class StaffScheduleController extends Controller
{
    public function index()
    {
        $staffs = Staff::with('schedules')->get();
        $days = [1 => 'Thứ Hai', 2 => 'Thứ Ba', 3 => 'Thứ Tư', 4 => 'Thứ Năm', 5 => 'Thứ Sáu', 6 => 'Thứ Bảy', 7 => 'Chủ Nhật'];
        
        return view('admin.staff_schedules.index', compact('staffs', 'days'));
    }

    public function create()
    {
        $staffs = Staff::all();
        $days = [1 => 'Thứ Hai', 2 => 'Thứ Ba', 3 => 'Thứ Tư', 4 => 'Thứ Năm', 5 => 'Thứ Sáu', 6 => 'Thứ Bảy', 7 => 'Chủ Nhật'];
        return view('admin.staff_schedules.create', compact('staffs', 'days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Kiểm tra tránh trùng lặp lịch làm việc
        $exists = StaffSchedule::where('staff_id', $request->staff_id)
                               ->where('day_of_week', $request->day_of_week)
                               ->exists();
        
        if ($exists) {
            return back()->withInput()->with('error', 'Nhân viên này đã có lịch làm việc cố định trong ngày này.');
        }

        StaffSchedule::create($request->all());
        
        return redirect()->route('admin.staff-schedules.index')->with('success', 'Đã thêm lịch làm việc cố định.');
    }

    // Không cần hàm show và edit/update vì lịch làm việc thường được quản lý bằng cách Xóa và Tạo mới.

    public function destroy(StaffSchedule $staff_schedule)
    {
        $staff_schedule->delete();
        return back()->with('success', 'Đã xóa lịch làm việc.');
    }
}