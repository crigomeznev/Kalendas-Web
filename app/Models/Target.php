<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $table = 'targets';
    public $timestamps = false;

    public $fillable = ['name', 'email', 'calendar_id'];
}
