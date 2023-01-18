<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    const CREATED_AT = 'date_c';
    const UPDATED_AT = null;


    public function Album(){
        return $this->belongsTo(Album::class);
    }
}
