<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class QuizResult extends Model
{
    protected $table = 'Quiz_Results';
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
