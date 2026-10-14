<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLearningProgress extends Model
{
    protected $primaryKey = 'user_id';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'current_streak',
        'max_streak',
        'last_active_date',
        'daily_goal_date',
        'daily_completed',
    ];

    protected function casts(): array
    {
        return [
            'last_active_date' => 'date',
            'daily_goal_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
