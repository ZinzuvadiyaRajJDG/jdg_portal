<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'date', 'clock_in', 'clock_out', 'total_hour', 'status','day','late','month','year','pause_time','resume_time'];

    protected $casts = [
        'pause_time' => 'array',
        'resume_time' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Salary model
    public function salary()
    {
        return $this->hasOne(Salary::class, 'attendance_id');
    }
}
