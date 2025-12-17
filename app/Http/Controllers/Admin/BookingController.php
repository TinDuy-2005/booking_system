<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Hiển thị danh sách lịch hẹn
    public function index()
    {
        // Lấy lịch hẹn mới nhất lên đầu, phân trang 10 dòng
        $bookings = Appointment::with(['user', 'service', 'staff'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    // 2. Duyệt lịch (Chuyển status -> confirmed)
    public function approve($id)
    {
        $booking = Appointment::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->back()->with('success', 'Đã duyệt lịch hẹn thành công!');
    }

    // 3. Hủy lịch (Chuyển status -> cancelled)
    public function cancel($id)
    {
        $booking = Appointment::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->back()->with('success', 'Đã hủy lịch hẹn!');
    }
}