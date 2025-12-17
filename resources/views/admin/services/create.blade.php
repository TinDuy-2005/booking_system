<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-sky-600 leading-tight">
            {{ __('Thêm Dịch Vụ Mới') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.services.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tên Dịch Vụ</label>
                        <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Ví dụ: Cắt tóc nam">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Thời lượng (phút)</label>
                        <input type="number" name="duration" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="30">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Giá tiền (VND)</label>
                        <input type="number" name="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="50000">
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('admin.services.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Hủy bỏ</a>
                        
                        <button type="submit" class="text-gray-600 hover:text-gray-900 mr-4">
                            Lưu Dịch Vụ
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>