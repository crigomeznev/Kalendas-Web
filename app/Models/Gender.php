<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gender extends Model
{
    use HasFactory;

    // ENUM
    public static function values () {
        // Create an instance of the model to be able to get the table name
        $instance = new static;
    
        // Pulls column string from DB
        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "gender"'))[0]->Type;
    
        // Parse string
        preg_match_all("/'([^']+)'/", $enumStr, $matches);
    
        // Return matches
        return isset($matches[1]) ? $matches[1] : [];
    }
}
