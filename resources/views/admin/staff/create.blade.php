<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Thêm Nhân Viên</h2></x-slot>
    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-bold mb-2">Họ Tên</label>
                <input type="text" name="name" class="border rounded w-full py-2 px-3" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Lưu lại</button>
        </form>
    </div></div>
</x-app-layout>