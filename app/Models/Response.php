<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'responder_ip', 'user_agent'];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    // public function user() {
    //     return $this->belongsTo(User::class);
    // }

}
