<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guskom extends Model
{
    use HasFactory;

    protected $table = 'guskom';

    protected $guarded = ['id'];
}
