<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
        'topic_id',
        'title',
        'description',
        'target_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'target_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
