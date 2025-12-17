<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Thêm Nhân Viên</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-bold mb-2">Họ Tên</label>
                <input type="text" name="name" class="border rounded w-full py-2 px-3" required>
            </div>
             <a href="{{ route('admin.staff.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Hủy bỏ</a>
            <button type="submit" class="text-gray-600 hover:text-gray-900 mr-4">Lưu </button>
        </form>
    </div></div>
</x-app-layout>