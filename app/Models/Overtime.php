<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'task_name',
        'datee',
        'clock_in',
        'clock_out',
        'total_hour',
        'overtime_salary',
        'year',
        'month',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
