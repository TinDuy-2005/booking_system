<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Đặt Lịch Hẹn Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-6 text-center uppercase border-b pb-4">
                    Thông tin đặt chỗ
                </h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Có lỗi xảy ra!</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Chọn Dịch vụ</label>
                            <select name="service_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->name }} ({{ $service->duration }} phút) - {{ number_format($service->price) }} VND
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-gray-700 mb-2">Chọn Nhân viên</label>
                            <select name="staff_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($staffs as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Ngày đặt</label>
                            <input type="date" name="date" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Giờ bắt đầu</label>
                            <input type="time" name="start_time" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded shadow-lg transition duration-150 ease-in-out transform hover:scale-105">
                            Xác nhận Đặt Lịch
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>