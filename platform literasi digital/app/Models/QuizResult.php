<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizResult extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'title',
        'subject',
        'correct_answers',
        'total_questions',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
