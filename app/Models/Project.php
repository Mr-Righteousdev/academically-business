<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_number',
        'client_id',
        'assigned_to',
        'service_type',
        'title',
        'description',
        'requirements',
        'quoted_price',
        'agreed_price',
        'deposit_paid',
        'total_paid',
        'balance',
        'payment_status',
        'status',
        'deadline',
        'started_at',
        'completed_at',
        'delivered_at',
        'estimated_hours',
        'actual_hours',
        'priority',
        'revision_count',
        'client_satisfaction',
    ];

    protected $casts = [
        'quoted_price' => 'decimal:2',
        'agreed_price' => 'decimal:2',
        'deposit_paid' => 'decimal:2',
        'total_paid' => 'decimal:2',
        'balance' => 'decimal:2',
        'deadline' => 'date',
        'started_at' => 'date',
        'completed_at' => 'date',
        'delivered_at' => 'date',
    ];

    // Relationships
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function timeLogs(): HasMany
    {
        return $this->hasMany(TimeLog::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['in_progress', 'review', 'revision']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                    ->whereNotIn('status', ['completed', 'delivered', 'cancelled']);
    }

    // Methods
    public function updateBalance(): void
    {
        $this->balance = $this->agreed_price - $this->total_paid;
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->project_number)) {
                $project->project_number = static::generateProjectNumber();
            }
        });
    }

    public function isOverdue(): bool
    {
        return $this->deadline && 
               $this->deadline->isPast() && 
               !in_array($this->status, ['completed', 'delivered', 'cancelled']);
    }

    protected static function generateProjectNumber(): string
    {
        $year = now()->format('Y');
        $lastProject = static::whereYear('created_at', $year)->latest()->first();
        $sequence = $lastProject ? (int) substr($lastProject->project_number, -3) + 1 : 1;
        
        return 'AA-' . $year . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}