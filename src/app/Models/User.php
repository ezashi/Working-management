<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function modificationRequests()
    {
        return $this->hasMany(ModificationRequest::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function todayAttendance()
    {
        return $this->attendances()->whereDate('date', today())->first();
    }

    public function currentStatus()
    {
        $attendance = $this->todayAttendance();
        return $attendance ? $attendance->status : 'not_working';
    }
}
