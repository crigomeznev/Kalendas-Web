<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';
    public $timestamps = false;

    protected $fillable = ['title', 'begins_at', 'ends_at', 'description', 'latitude', 'longitude', 'calendar_id', 'creator_id'];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }    

    public function category()
    {
        return $this->belongsTo(Category::class);
    }    

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }    
}
