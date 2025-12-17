<?php
// app/Http/Controllers/Admin/AppointmentController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'staff', 'service'])
                                   ->orderBy('start_time', 'asc')
                                   ->paginate(20);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Đã cập nhật trạng thái lịch hẹn.');
    }
}