<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'source',
        'status',
        'inquiry_details',
        'service_interested',
        'lost_reason',
        'converted_to_client_id',
        'contacted_at',
        'converted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    // Relationships
    public function convertedClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'converted_to_client_id');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_to_client_id');
    }

    public function scopeWon($query)
    {
        return $query->where('status', 'won');
    }

    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    // Methods
    public function markAsContacted(): void
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
        ]);
    }

    public function convertToClient(Lead $client): void
    {
        $this->update([
            'status' => 'won',
            'converted_to_client_id' => $client->id,
            'converted_at' => now(),
        ]);
    }
}