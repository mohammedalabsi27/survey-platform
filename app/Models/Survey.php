<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'slug', 'description', 'status', 'start_date', 'end_date', 'theme_color', 'thank_you_message'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function responses() {
        return $this->hasMany(Response::class);
    }

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($survey) {
            if (empty($survey->slug)) {
                // توليد رابط من العنوان + 6 حروف عشوائية لضمان عدم التكرار
                $survey->slug = Str::slug($survey->title) . '-' . Str::random(6);
            }
        });
    }
}
