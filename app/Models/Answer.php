<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer_text', 'image_url', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected $casts = [
        'is_correct' => 'boolean',
    ];
    
}
