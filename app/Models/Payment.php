<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'recorded_by',
        'amount',
        'payment_method',
        'transaction_reference',
        'payment_type',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    // Relationships
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            $payment->project->update([
                'total_paid' => $payment->project->payments()->sum('amount'),
            ]);
            $payment->project->updateBalance();

            // Update payment status
            $project = $payment->project;
            $totalPaid = $project->total_paid;
            $agreedPrice = $project->agreed_price;

            if ($totalPaid >= $agreedPrice) {
                $project->update(['payment_status' => 'fully_paid']);
            } elseif ($totalPaid > 0) {
                $project->update(['payment_status' => 'partially_paid']);
            }
        });
    }
}