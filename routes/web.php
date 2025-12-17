<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// --- QUAN TRỌNG: Thêm các dòng này để gọi Model ---
use App\Models\Service;
use App\Models\Staff;
use App\Models\Appointment; 
// ------------------------------------------------

Route::get('/', function () {
    return view("welcome");
});

// Nhóm chức năng Đăng nhập
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- SỬA ĐOẠN NÀY ---
    Route::get('/dashboard', function () {
        // Kiểm tra nếu là Admin
        if (auth()->user()->role === 'admin') {
            
            // 1. Lấy số liệu thống kê
            $totalServices = Service::count();
            $totalStaff = Staff::count();
           $todayAppointments = Appointment::whereDate('start_time', now()->toDateString())->count();

            // 2. Lấy 5 lịch hẹn mới nhất để hiện ở "Quản lý nhanh"
            // (Giả sử bạn đã tạo quan hệ: appointment -> user, service, staff)
           $recentAppointments = Appointment::with(['user', 'service', 'staff'])
                        ->orderBy('start_time', 'desc') // Sắp xếp theo giờ bắt đầu là đủ
                        ->take(5)
                        ->get();

            // Truyền biến sang view admin.dashboard
            return view('admin.dashboard', compact('totalServices', 'totalStaff', 'todayAppointments', 'recentAppointments'));
        }

        // Nếu là khách hàng -> chuyển sang trang đặt lịch
        return redirect()->route('admin.booking.index');
    })->name('dashboard');
    // ---------------------

    // Chức năng Đặt lịch
    
    Route::get('/booking', function (){
    return view("admin.bookings.index");
})->name('admin.booking.index');

    Route::post('/booking/get-slots', [BookingController::class, 'getSlots'])->name('get.slots');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- NHÓM ADMIN ---
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Route Dịch vụ
    Route::resource('services', ServiceController::class);
    // Route Nhân viên
    Route::resource('staff', StaffController::class);
    // Route Booking
   // 1. Xem danh sách
    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    
    // 2. Duyệt lịch
    Route::patch('/bookings/{id}/approve', [\App\Http\Controllers\Admin\BookingController::class, 'approve'])->name('bookings.approve');
    
    // 3. Hủy lịch
    Route::patch('/bookings/{id}/cancel', [\App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
});

require __DIR__.'/auth.php';