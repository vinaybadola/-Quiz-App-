<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuizResult;

class User extends Model
{
    use HasFactory;
    public function course(){
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

   
}
