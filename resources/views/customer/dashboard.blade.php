<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trang Chủ Khách Hàng') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Xin chào, {{ Auth::user()->name }}! Bạn muốn làm gì hôm nay?</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <a href="{{ route('booking.index') }}" class="block p-6 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition transform hover:-translate-y-1 shadow-sm">
                        <div class="text-4xl mb-3">📅</div>
                        <div class="font-bold text-xl text-indigo-700 mb-2">Đặt Lịch Hẹn Mới</div>
                        <p class="text-sm text-gray-600">Chọn dịch vụ, nhân viên và khung giờ bạn muốn.</p>
                    </a>

                    <a href="{{ route('booking.history') }}" class="block p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition transform hover:-translate-y-1 shadow-sm">
                        <div class="text-4xl mb-3">📋</div>
                        <div class="font-bold text-xl text-green-700 mb-2">Lịch Sử Của Tôi</div>
                        <p class="text-sm text-gray-600">Xem lại trạng thái các đơn đã đặt (Duyệt/Hủy).</p>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block p-6 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition transform hover:-translate-y-1 shadow-sm">
                        <div class="text-4xl mb-3">👤</div>
                        <div class="font-bold text-xl text-gray-700 mb-2">Thông Tin Cá Nhân</div>
                        <p class="text-sm text-gray-600">Cập nhật hồ sơ, mật khẩu và email.</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>