<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'program',
        'year_of_study',
        'source',
        'referral_source',
        'status',
        'notes',
        'lifetime_value',
        'projects_count',
    ];

    protected $casts = [
        'lifetime_value' => 'decimal:2',
    ];

    // Relationships
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function referredLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'converted_to_client_id');
    }

    public function referralsGiven(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_client_id');
    }

    public function referralsReceived(): HasMany
    {
        return $this->hasMany(Referral::class, 'referred_client_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInquiry($query)
    {
        return $query->where('status', 'inquiry');
    }

    public function scopeWithProjects($query)
    {
        return $query->where('projects_count', '>', 0);
    }
}