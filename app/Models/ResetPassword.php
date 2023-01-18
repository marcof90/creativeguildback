<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'code', 'created_at'
    ];

    /**
     * check if the code is expire then delete
     *
     * @return void
     */
    public function expired()
    {
        if ( now() > $this->created_at->addDay()) {
            return true;
        }
        return false;
    }

}
