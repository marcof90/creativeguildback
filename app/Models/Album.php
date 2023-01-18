<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;


    public function User(){
        return $this->hasOne(User::class);
    }

    public function Pictures(){
        return $this->hasMany(Picture::class);
    }

}
