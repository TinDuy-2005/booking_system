<?php
// app/Services/TimeSlotService.php
namespace App\Services;

use App\Models\Staff;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class TimeSlotService
{
    /**
     * Lấy danh sách các khung giờ còn trống (H:i) cho nhân viên, ngày và dịch vụ cụ thể.
     * * @param Staff $staff Nhân viên được chọn
     * @param Carbon $date Ngày được chọn
     * @param Service $service Dịch vụ được chọn (để lấy thời lượng)
     * @return array Danh sách giờ trống, ví dụ: ["09:00", "10:00", ...]
     */
    public function getAvailableSlots(Staff $staff, Carbon $date, Service $service): array
    {
        $dayOfWeek = $date->dayOfWeekIso; // 1 (Thứ Hai) đến 7 (Chủ Nhật)
        $duration = $service->duration;

        // 1. Lấy lịch làm việc cố định của nhân viên trong ngày đó
        $schedule = $staff->schedules()
                          ->where('day_of_week', $dayOfWeek)
                          ->first();

        if (!$schedule) {
            return []; // Nhân viên không làm việc ngày này
        }

        // Tạo Carbon object cho thời gian bắt đầu và kết thúc ca làm việc
        $start_time = Carbon::parse($date->toDateString() . ' ' . $schedule->start_time);
        $end_time = Carbon::parse($date->toDateString() . ' ' . $schedule->end_time);

        // 2. Lấy các lịch hẹn đã chiếm chỗ (Pending hoặc Confirmed)
        $occupiedAppointments = Appointment::where('staff_id', $staff->id)
                                          ->whereDate('start_time', $date->toDateString())
                                          ->whereIn('status', ['pending', 'confirmed'])
                                          ->get();

        $availableSlots = [];
        $currentSlot = $start_time->copy();

        // 3. Lặp qua các khoảng thời gian khả dĩ
        while ($currentSlot->lessThan($end_time)) {
            $slotStart = $currentSlot->copy();
            $slotEnd = $currentSlot->copy()->addMinutes($duration);

            // Đảm bảo slot kết thúc trong ca làm việc
            if ($slotEnd->greaterThan($end_time)) {
                break;
            }

            // Kiểm tra xem slot hiện tại có chồng chéo với bất kỳ lịch hẹn nào đã có không
            $isOccupied = $occupiedAppointments->contains(function ($appointment) use ($slotStart, $slotEnd) {
                $appointmentStart = Carbon::parse($appointment->start_time);
                $appointmentEnd = Carbon::parse($appointment->end_time);

                // Logic chồng chéo: (Start Slot < End Appointment) AND (End Slot > Start Appointment)
                return ($slotStart->lt($appointmentEnd) && $slotEnd->gt($appointmentStart));
            });

            // Kiểm tra xem slot có bắt đầu trong quá khứ không
            if ($slotStart->lessThan(Carbon::now())) {
                $isOccupied = true;
            }

            if (!$isOccupied) {
                // Thêm slot khả dụng vào danh sách
                $availableSlots[] = $slotStart->format('H:i');
            }

            // Chuyển sang slot tiếp theo (bằng thời lượng dịch vụ)
            $currentSlot->addMinutes($duration);
        }

        return $availableSlots;
    }
}