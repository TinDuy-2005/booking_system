<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các thuộc tính có thể gán hàng loạt (Mass Assignable).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <-- Thêm role
    ];

    /**
     * Các thuộc tính nên bị ẩn khi xuất (Hidden for serialization).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu thuộc tính.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Mối quan hệ: Một User (Khách hàng) có nhiều Lịch hẹn
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}