<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_client_id',
        'referred_client_id',
        'project_id',
        'status',
        'reward_amount',
        'reward_type',
        'rewarded_at',
    ];

    protected $casts = [
        'reward_amount' => 'decimal:2',
        'rewarded_at' => 'datetime',
    ];

    // Relationships
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'referrer_client_id');
    }

    public function referred(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'referred_client_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRewarded($query)
    {
        return $query->where('status', 'rewarded');
    }

    // Methods
    public function markAsRewarded(): void
    {
        $this->update([
            'status' => 'rewarded',
            'rewarded_at' => now(),
        ]);
    }
}