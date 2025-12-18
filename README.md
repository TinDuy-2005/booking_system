# 📅 Hệ Thống Đặt Lịch Dịch Vụ (Service Booking System)

Một ứng dụng web trọn gói xây dựng bằng **Laravel**, cho phép khách hàng đặt lịch hẹn dịch vụ trực tuyến (Salon, Spa, Phòng khám...) và cung cấp công cụ quản lý toàn diện cho chủ cửa hàng.

---

## 🚀 Giới Thiệu

Dự án được xây dựng nhằm giải quyết bài toán quản lý lịch hẹn thủ công, giúp:
- **Khách hàng:** Chủ động chọn dịch vụ, nhân viên và khung giờ rảnh mà không cần gọi điện. Tránh việc đến nơi phải chờ đợi.
- **Chủ cửa hàng:** Quản lý tập trung, tránh trùng lịch, theo dõi đơn hàng và hiệu suất nhân viên.

---

## ✨ Chức Năng Chính

### 👤 Dành cho Khách hàng (Customer)
- [x] **Đăng ký / Đăng nhập:** Hệ thống tài khoản bảo mật.
- [x] **Đặt lịch thông minh:**
  - Chọn Dịch vụ (Tự động tính tổng tiền).
  - Chọn Nhân viên yêu thích.
  - Chọn Ngày & Giờ.
  - **Tự động lọc giờ rảnh (Dynamic Time Slots):** Hệ thống tự động ẩn các giờ đã có người đặt hoặc giờ nghỉ trưa/tối.
- [x] **Quản lý lịch sử:** Xem danh sách lịch hẹn, theo dõi trạng thái (Chờ duyệt / Đã duyệt / Đã hủy).
- [x] **Cập nhật hồ sơ:** Chỉnh sửa thông tin cá nhân, đổi mật khẩu.

### 👑 Dành cho Quản trị viên (Admin)
- [x] **Dashboard:** Thống kê tổng quan (Số đơn hàng ngày, tổng số dịch vụ, nhân viên...).
- [x] **Quản lý Dịch vụ:** Thêm mới, sửa giá tiền, thời gian thực hiện, xóa dịch vụ.
- [x] **Quản lý Nhân viên:** Thêm, sửa, xóa nhân viên.
- [x] **Xử lý Đơn hàng:** Xem danh sách lịch hẹn sắp tới, thực hiện **Duyệt** hoặc **Hủy** lịch.

---

## 🛠 Công Nghệ Sử Dụng

- **Backend:** Laravel Framework (PHP 8.x+).
- **Frontend:** Blade Template, Tailwind CSS (Giao diện hiện đại, Responsive).
- **Database:** MySQL.
- **Kỹ thuật nổi bật:**
  - **Fetch API / AJAX:** Xử lý logic chọn giờ Time Slots realtime không cần tải lại trang.
  - **Authentication:** Laravel Breeze (Phân quyền Admin/User bằng Middleware).
  - **Algorithm:** Thuật toán kiểm tra trùng lịch (Overlap Check).

---

## ⚙️ Hướng Dẫn Cài Đặt & Chạy Dự Án

Làm theo các bước sau để chạy dự án trên máy local:

### 1. Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### 2. Các bước cài đặt

**Bước 1: Clone dự án
```bash
git clone https://github.com/TinDuy-2005/booking_system.git
cd booking-system

**Bước 2: Cài đặt các thư viện (Dependencies)
```bash
composer install
npm install

**Bước 3: Cấu hình môi trường


```bash
cp .env.example .env
Mở file .env và cấu hình thông tin Database của bạn:

Code snippet

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database_cua_ban
DB_USERNAME=root
DB_PASSWORD=
**Bước 4: Tạo Key và Build giao diện

```bash

php artisan key:generate
npm run build

**Bước 5: Khởi tạo Database

```bash

php artisan migrate
php artisan db:seed

**Bước 6: Chạy dự án

```bash

php artisan serve
Truy cập tại: http://127.0.0.1:8000
 
 *Đăng nhập :
 Tài khoản :Admin
  username : admin@gmail.com,
  password: 12345678
 Tài khoản :Cutomer
  username : cutomer@gmail.com,
  password: 123456