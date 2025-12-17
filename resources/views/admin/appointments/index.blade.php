{{-- resources/views/admin/appointments/index.blade.php --}}
@extends('admin.layouts.app') 

@section('title', 'Quản lý Lịch hẹn')

@section('content')
<div class="container-fluid">
    <h2>Quản lý Lịch hẹn</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Nhân viên</th>
                <th>Dịch vụ</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->id }}</td>
                <td>{{ $appointment->user->name }}</td>
                <td>{{ $appointment->staff->name }}</td>
                <td>{{ $appointment->service->name }} ({{ $appointment->service->duration }} phút)</td>
                <td>{{ $appointment->start_time->format('d/m H:i') }}</td>
                <td>
                    <span class="badge {{ $appointment->status == 'confirmed' ? 'text-bg-success' : ($appointment->status == 'cancelled' ? 'text-bg-danger' : 'text-bg-warning') }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment) }}">
                        @csrf
                        <select name="status" class="form-select form-select-sm d-inline w-auto me-2">
                            <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Xác nhận</option>
                            <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Hủy bỏ</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection