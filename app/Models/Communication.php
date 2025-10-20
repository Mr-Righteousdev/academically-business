<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'project_id',
        'user_id',
        'type',
        'direction',
        'summary',
        'notes',
        'communicated_at',
    ];

    protected $casts = [
        'communicated_at' => 'datetime',
    ];

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('communicated_at', '>=', now()->subDays($days));
    }
}