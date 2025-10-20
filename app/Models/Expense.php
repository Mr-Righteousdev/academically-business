<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'category',
        'amount',
        'description',
        'expense_date',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
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

    // Scopes
    public function scopeThisMonth($query)
    {
        return $query->whereYear('expense_date', now()->year)
                    ->whereMonth('expense_date', now()->month);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}