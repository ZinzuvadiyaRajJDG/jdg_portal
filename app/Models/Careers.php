<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'number',
        'address',
        'linkedin_url',
        'position',
        'experience',
        'skills',
        'reference',
        'ctc',
        'ectc',
        'resume',
        'rejected_message',
        'previous_applied',
    ];
}
