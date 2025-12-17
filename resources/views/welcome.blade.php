<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hệ Thống Quản Lý Dịch Vụ</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sky: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9', // Màu chủ đạo của bạn
                            600: '#0284c7',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans">

    <nav class="w-full py-6 px-6 lg:px-12 flex justify-between items-center absolute top-0 z-10">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-sky-500 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                S
            </div>
            <span class="text-xl font-bold text-slate-900 tracking-tight">Service<span class="text-sky-500">Manager</span></span>
        </div>

        <div class="flex gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-slate-600 hover:text-sky-600 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-slate-600 hover:text-sky-600 transition px-4 py-2">Đăng nhập</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hidden sm:block font-semibold bg-sky-500 text-white px-5 py-2 rounded-full hover:bg-sky-600 transition shadow-md shadow-sky-200">
                            Đăng ký
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
        
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-sky-200 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-200 rounded-full blur-3xl opacity-30"></div>

        <div class="container mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative z-10 pt-20">
            
            <div class="text-center lg:text-left">
                <div class="inline-block px-4 py-1.5 mb-6 bg-sky-100 text-sky-700 font-semibold rounded-full text-sm">
                    ✨ Hệ thống quản lý chuyên nghiệp
                </div>
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6 text-slate-900">
                    Nâng tầm dịch vụ <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-blue-600">
                        Cửa hàng của bạn
                    </span>
                </h1>
                <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Quản lý lịch hẹn, nhân viên và doanh thu một cách dễ dàng. 
                    Giải pháp tối ưu giúp bạn tiết kiệm thời gian và tăng trưởng kinh doanh.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-8 py-3.5 bg-sky-500 text-white text-lg font-semibold rounded-xl hover:bg-sky-600 transition shadow-lg shadow-sky-200 transform hover:-translate-y-1">
                            Truy cập quản lý
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-8 py-3.5 bg-sky-500 text-white text-lg font-semibold rounded-xl hover:bg-sky-600 transition shadow-lg shadow-sky-200 transform hover:-translate-y-1">
                            Bắt đầu ngay
                        </a>
                        <a href="#features" class="px-8 py-3.5 bg-white text-slate-700 border border-slate-200 text-lg font-semibold rounded-xl hover:bg-slate-50 transition">
                            Tìm hiểu thêm
                        </a>
                    @endauth
                </div>
                
                <div class="mt-10 flex items-center justify-center lg:justify-start gap-8 text-slate-500 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Dễ sử dụng
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Bảo mật cao
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Hỗ trợ 24/7
                    </div>
                </div>
            </div>

            <div class="relative hidden lg:block">
                <div class="bg-white p-4 rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500 border border-slate-100">
                    <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Dashboard Preview" class="rounded-xl w-full h-auto object-cover">
                    
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-slate-50 flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Doanh thu hôm nay</p>
                            <p class="text-sm font-bold text-slate-800">+ 1,250,000 đ</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>