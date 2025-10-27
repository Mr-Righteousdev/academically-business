<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'contributed_by',
        'amount',
        'purpose',
        'date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contributed_by');
    }

    protected static function booted(): void
    {
        static::creating(function ($contribution) {
            // Automatically assign the logged-in user if not set
            if (Auth::check() && !$contribution->contributed_by) {
                $contribution->contributed_by = Auth::id();
            }
        });
    }
}
