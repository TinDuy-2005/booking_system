<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Service;
use App\Models\Staff;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo user Admin + Customer
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]);

            User::create([
                'name' => 'Customer User',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'customer',
            ]);
        }

        // 2. Tạo Service mẫu
        Service::create(['name' => 'Cắt tóc nam', 'duration' => 30, 'price' => 50000]);
        Service::create(['name' => 'Gội đầu Massage', 'duration' => 60, 'price' => 100000]);
        Service::create(['name' => 'Nhuộm tóc', 'duration' => 120, 'price' => 300000]);
        Service::create(['name' => 'Lấy ráy tai', 'duration' => 15, 'price' => 30000]);

        // 3. Tạo Staff mẫu
        Staff::create(['name' => 'Nguyễn Văn A']);
        Staff::create(['name' => 'Trần Thị B']);
        Staff::create(['name' => 'Lê Văn C']);
    }
}
