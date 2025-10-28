<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disbursement extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'recorded_by',
        'amount',
        'disbursed_on',
        'method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'disbursed_on' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($disbursement) {
            if (Auth::check() && !$disbursement->recorded_by) {
                $disbursement->recorded_by = Auth::id();
            }
        });
    }
}
    
