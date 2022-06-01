<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $table = 'calendars';
    public $timestamps = false;

    public $fillable = ['title', 'owner_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function helpers()
    {
        return $this->hasMany(Helper::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
