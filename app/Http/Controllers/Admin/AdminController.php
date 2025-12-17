<?php
// app/Http/Controllers/Admin/AdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Hiển thị trang Dashboard cho Admin
     */
    public function index()
    {
        // Thống kê đơn giản
        $stats = [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_users' => User::where('role', 'customer')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}