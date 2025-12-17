<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Đặt Lịch Hẹn</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div style="color: green; margin-bottom: 20px;">{{ session('success') }}</div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label>Chọn Dịch vụ:</label>
                        <select name="service_id" id="service" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            <option value="">-- Chọn --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->duration }} phút)</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Chọn Nhân viên:</label>
                        <select name="staff_id" id="staff" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                            @foreach($staffs as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>Ngày:</label>
                        <input type="date" name="date" id="date" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full">
                    </div>

                    <div class="mb-4" id="time-section" style="display:none;">
                        <label>Giờ Trống:</label>
                        <div id="slots-container" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                        <input type="hidden" name="time" id="selected-time" required>
                    </div>

                    <button type="submit" style="background: blue; color: white; padding: 10px 20px; border-radius: 5px;">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Khi thay đổi ngày, gọi API để lấy giờ trống
        document.getElementById('date').addEventListener('change', function() {
            let service = document.getElementById('service').value;
            let staff = document.getElementById('staff').value;
            let date = this.value;

            if(!service || !staff) { alert('Vui lòng chọn Dịch vụ và Nhân viên trước'); return; }

            fetch('{{ route("get.slots") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ service_id: service, staff_id: staff, date: date })
            })
            .then(res => res.json())
            .then(slots => {
                let container = document.getElementById('slots-container');
                container.innerHTML = '';
                document.getElementById('time-section').style.display = 'block';

                if(slots.length === 0) {
                    container.innerHTML = '<span>Hết giờ trống!</span>';
                }

                slots.forEach(time => {
                    let btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerText = time;
                    btn.style.padding = '5px 10px';
                    btn.style.border = '1px solid #ccc';
                    
                    btn.onclick = function() {
                        // Reset màu các nút khác
                        document.querySelectorAll('#slots-container button').forEach(b => b.style.background = 'white');
                        // Đổi màu nút đang chọn
                        this.style.background = '#ccc';
                        document.getElementById('selected-time').value = time;
                    };
                    container.appendChild(btn);
                });
            });
        });
    </script>
</x-app-layout>