<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','name', 'salary','status','total_attendance','totalsalary','month','year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Attendance model
    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
}
