<?php
// app/Models/Service.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = ['name', 'duration', 'price'];

    // Mối quan hệ: Một Service có nhiều Appointments
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}