<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// database/seeders/MasterDataSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Staff;
use App\Models\StaffSchedule;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Dịch vụ
        $serviceA = Service::create([
            'name' => 'Cắt tóc Cơ bản',
            'duration' => 30, // 30 phút
            'price' => 100000,
        ]);
        $serviceB = Service::create([
            'name' => 'Gội đầu & Massage',
            'duration' => 60, // 60 phút
            'price' => 250000,
        ]);

        // 2. Tạo Nhân viên
        $staffA = Staff::create([
            'name' => 'Nguyễn Văn A',
            // user_id = null nếu không cần tài khoản đăng nhập riêng
        ]);
        $staffB = Staff::create([
            'name' => 'Trần Thị B',
        ]);

        // 3. Tạo Lịch làm việc (StaffSchedules)

        // Nhân viên A làm việc từ Thứ Hai (1) đến Thứ Sáu (5)
        for ($i = 1; $i <= 5; $i++) {
            StaffSchedule::create([
                'staff_id' => $staffA->id,
                'day_of_week' => $i,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
            ]);
        }
        
        // Nhân viên B chỉ làm việc Thứ Bảy (6) và Chủ Nhật (7)
        StaffSchedule::create(['staff_id' => $staffB->id, 'day_of_week' => 6, 'start_time' => '10:00:00', 'end_time' => '19:00:00']);
        StaffSchedule::create(['staff_id' => $staffB->id, 'day_of_week' => 7, 'start_time' => '10:00:00', 'end_time' => '19:00:00']);
    }
}