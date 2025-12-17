<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// 1. Import Controller của KHÁCH
use App\Http\Controllers\BookingController; 

// 2. Import Controller của ADMIN
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;

// 3. Import Models
use App\Models\Service;
use App\Models\Staff;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ====================================================
// NHÓM 1: ĐĂNG NHẬP & DASHBOARD CHUNG
// ====================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Route xử lý trang chủ sau khi đăng nhập
    Route::get('/dashboard', function () {
        
        // A. NẾU LÀ ADMIN -> Trả về View Thống Kê
        if (auth()->user()->role === 'admin') {
            $totalServices = Service::count();
            $totalStaff = Staff::count();
            // Lưu ý: Đảm bảo bạn có model Appointment hoặc đổi thành Booking tùy DB
            $todayAppointments = Appointment::whereDate('start_time', now()->toDateString())->count();

            $recentAppointments = Appointment::with(['user', 'service', 'staff'])
                                    ->orderBy('start_time', 'desc')
                                    ->take(5)
                                    ->get();

            return view('admin.dashboard', compact('totalServices', 'totalStaff', 'todayAppointments', 'recentAppointments'));
        }

        // B. NẾU LÀ KHÁCH HÀNG
        return view('customer.dashboard'); 

    })->name('dashboard');

    // ====================================================
    // NHÓM 2: CHỨC NĂNG CHO KHÁCH HÀNG (Customer)
    // ====================================================
    
    // 1. Trang Form đặt lịch
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    
    // 2. Xử lý lưu lịch vào Database
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    
    // 3. Xem lịch sử đặt chỗ
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');

    // 4. API lấy giờ rảnh (ĐÃ CHUYỂN LÊN ĐÂY LÀ ĐÚNG)
    // Đường dẫn sẽ là: /get-available-time (Khớp với Javascript)
    Route::get('/get-available-time', [BookingController::class, 'getAvailableTime'])->name('get.available.time');

    // 5. Quản lý Profile cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================================================
// NHÓM 3: CHỨC NĂNG QUẢN TRỊ (ADMIN)
// ====================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Quản lý Dịch vụ
    Route::resource('services', ServiceController::class);
    
    // Quản lý Nhân viên
    Route::resource('staff', StaffController::class);

    // Quản lý Booking (Duyệt/Hủy)
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{id}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
});

require __DIR__.'/auth.php';