<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'task_id',
        'description',
        'started_at',
        'ended_at',
        'minutes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    // Methods
    public function stopTimer(): void
    {
        if ($this->ended_at === null && $this->started_at) {
            $this->ended_at = now();
            $this->minutes = $this->started_at->diffInMinutes($this->ended_at);
            $this->save();

            // Update project actual hours
            $this->project->increment('actual_hours', $this->minutes / 60);
        }
    }

    public function isRunning(): bool
    {
        return $this->started_at !== null && $this->ended_at === null;
    }
}