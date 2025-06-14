<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificationRequest extends Model
{
    /** @use HasFactory<\Database\Factories\ModificationRequestFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'attendance_id',
        'user_id',
        'check_in',
        'check_out',
        'breaks',
        'note',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'breaks' => 'array',
        'approved_at' => 'datetime',
    ];


    /**
     * Get the attendance associated with the modification request.
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
