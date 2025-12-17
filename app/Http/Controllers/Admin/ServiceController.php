<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // 1. Hiển thị danh sách
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    // 2. Hiển thị form thêm mới
    public function create()
    {
        return view('admin.services.create');
    }

    // 3. Lưu dữ liệu mới (Store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Thêm dịch vụ thành công!');
    }

    // 4. Hiển thị form chỉnh sửa (Edit)
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
    }

    // 5. Cập nhật dữ liệu (Update)
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:15',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công!');
    }

    // 6. Xóa dữ liệu (Destroy)
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công!');
    }
}