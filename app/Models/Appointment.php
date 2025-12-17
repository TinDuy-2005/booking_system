<?php
// app/Models/Appointment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'staff_id',
        'service_id',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Tự động chuyển đổi sang đối tượng Carbon (quan trọng cho Time Slot)
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Mối quan hệ: Lịch hẹn thuộc về một User (Khách hàng)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Mối quan hệ: Lịch hẹn thuộc về một Staff (Nhân viên)
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    // Mối quan hệ: Lịch hẹn thuộc về một Service (Dịch vụ)
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}