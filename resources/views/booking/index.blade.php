<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sky-600 leading-tight">
            {{ __('Đặt Lịch Hẹn Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-8 bg-white border-b border-gray-100">
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-6 text-center uppercase tracking-wide">
                        Thông tin đặt chỗ
                    </h3>

                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Chọn Dịch vụ</label>
                                <select name="service_id" id="service_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-200 transition p-2.5">
                                    <option value="" data-price="0">-- Chọn dịch vụ --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                            {{ $service->name }} ({{ $service->duration }} phút)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Chọn Nhân viên</label>
                                <select name="staff_id" id="staff_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-200 transition p-2.5">
                                    <option value="">-- Chọn nhân viên --</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Ngày đặt</label>
                                <input type="date" name="date" id="date_input" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-200 transition p-2.5" required>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Giờ trống (Available)</label>
                               <select name="start_time" id="time_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-sky-500 focus:ring-sky-200 transition p-2.5 bg-gray-50" disabled required>
    <option value="">-- Vui lòng chọn NV & Ngày --</option>
</select>
                                <p id="loading_text" class="text-xs text-sky-500 mt-1 hidden">Drafting available slots...</p>
                            </div>
                        </div>

                        <div class="mt-8 mb-4 p-4 bg-sky-50 border border-sky-100 rounded-lg flex justify-between items-center" id="price_box">
                            <span class="text-sky-800 font-semibold">Chi phí dự kiến:</span>
                            <span id="total_price_display" class="text-2xl font-bold text-sky-600">0 VND</span>
                        </div>

                        <div class="flex justify-end mt-8">
                            <button type="submit" 
                                    style="background-color: #0ea5e9; color: white; padding: 12px 32px; border-radius: 8px; font-weight: bold; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);"
                                    class="hover:opacity-90 transition transform hover:-translate-y-0.5">
                                Xác nhận Đặt Lịch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khai báo các biến
            const serviceSelect = document.getElementById('service_select');
            const priceDisplay = document.getElementById('total_price_display');
            const staffSelect = document.getElementById('staff_select');
            const dateInput = document.getElementById('date_input');
            const timeSelect = document.getElementById('time_select');
            const loadingText = document.getElementById('loading_text');

            // 1. Tự động tính tiền (Code cũ)
            serviceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price');
                priceDisplay.textContent = price ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price) : '0 VND';
            });

            // 2. Hàm lấy giờ rảnh từ Server (Code Mới)
            async function fetchAvailableSlots() {
                const staffId = staffSelect.value;
                const date = dateInput.value;

                // Chỉ chạy khi đã chọn đủ Nhân viên và Ngày
                if (!staffId || !date) {
                    timeSelect.innerHTML = '<option value="">-- Vui lòng chọn NV & Ngày --</option>';
                    timeSelect.disabled = true;
                    timeSelect.classList.add('bg-gray-50');
                    return;
                }

                // Hiệu ứng Loading
                timeSelect.disabled = true;
                loadingText.classList.remove('hidden');
                timeSelect.innerHTML = '<option>Đang tìm giờ trống...</option>';

                try {
                    // Gọi API chúng ta vừa tạo ở Bước 1
                    const response = await fetch(`/get-available-time?staff_id=${staffId}&date=${date}`);
                    const slots = await response.json();

                    // Xóa cũ, thêm mới
                    timeSelect.innerHTML = '';
                    
                    if (slots.length > 0) {
                        timeSelect.disabled = false;
                        timeSelect.classList.remove('bg-gray-50');
                        
                        // Thêm option mặc định
                        const defaultOpt = document.createElement('option');
                        defaultOpt.text = "-- Chọn giờ --";
                        defaultOpt.value = "";
                        timeSelect.add(defaultOpt);

                        // Loop qua danh sách giờ rảnh và hiển thị
                        slots.forEach(time => {
                            const option = document.createElement('option');
                            option.value = time; // Giá trị gửi lên server (Ví dụ: 07:30)
                            option.text = time;  // Chữ hiển thị
                            timeSelect.add(option);
                        });
                    } else {
                        timeSelect.innerHTML = '<option value="">Hết giờ trống ngày này!</option>';
                    }

                } catch (error) {
                    console.error('Lỗi:', error);
                    timeSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
                } finally {
                    loadingText.classList.add('hidden');
                }
            }

            // Gọi hàm mỗi khi đổi Nhân viên hoặc Ngày
            staffSelect.addEventListener('change', fetchAvailableSlots);
            dateInput.addEventListener('change', fetchAvailableSlots);
        });
    </script>
</x-app-layout>