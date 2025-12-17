<?php
// app/Models/Staff.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = ['name', 'user_id'];

    // Mối quan hệ: Một Staff có nhiều StaffSchedules (Lịch làm việc cố định)
    public function schedules(): HasMany
    {
        return $this->hasMany(StaffSchedule::class);
    }

    // Mối quan hệ: Một Staff có nhiều Appointments (Lịch hẹn thực tế)
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}