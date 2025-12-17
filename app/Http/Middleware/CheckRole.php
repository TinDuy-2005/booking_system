<?php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Xử lý yêu cầu đến.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Vai trò yêu cầu (ví dụ: 'admin')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            return redirect('/login');
        }

        // 2. Kiểm tra vai trò của người dùng
        if (Auth::user()->role !== $role) {
            // Nếu vai trò không khớp, chuyển hướng hoặc trả về lỗi
            // Chuyển hướng về trang dashboard mặc định
            return redirect('/dashboard')->with('error', 'Bạn không có quyền truy cập khu vực này.');
        }

        // 3. Nếu mọi thứ hợp lệ, cho phép yêu cầu tiếp tục
        return $next($request);
    }
}