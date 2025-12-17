<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // 1. Danh sách nhân viên
    public function index()
    {
        $staffs = Staff::all();
        return view('admin.staff.index', compact('staffs'));
    }

    // 2. Form thêm mới
    public function create()
    {
        return view('admin.staff.create');
    }

    // 3. Lưu nhân viên mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'bio' => 'nullable|string', // Nếu bạn muốn thêm mô tả
        ]);

        Staff::create($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Thêm nhân viên thành công!');
    }

    // 4. Form sửa
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    // 5. Cập nhật
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $staff->update($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    // 6. Xóa
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Xóa nhân viên thành công!');
    }
}