<?php
// app/Models/StaffSchedule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffSchedule extends Model
{
    protected $fillable = [
        'staff_id',
        'day_of_week', // 1=Thứ Hai, 7=Chủ Nhật
        'start_time',
        'end_time'
    ];

    // Mối quan hệ: Một StaffSchedule thuộc về một Staff
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}