<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IconLink extends Model
{
    use HasFactory;
    protected $table = 'iconlinks';

    protected $fillable = ['name', 'link', 'banner_image'];
}
