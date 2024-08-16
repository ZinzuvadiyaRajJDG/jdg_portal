<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpipoint extends Model
{
    use HasFactory;
    protected $table = 'kpipoints';

    protected $fillable = ['user_id', 'ctm_points', 'month', 'year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
