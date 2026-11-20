<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'role_or_company',
        'phone_or_contact',
        'category',
        'primary_need',
        'ego_trigger',
        'notes',
    ];

    public const CATEGORIES = [
        'client' => 'Klien',
        'prospect' => 'Prospek',
        'partner' => 'Partner Bisnis',
        'colleague' => 'Kolega',
        'other' => 'Lainnya',
    ];

    /**
     * Get the user that owns this contact.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Category badge colors and styling.
     */
    public function getCategoryBadgeClassesAttribute(): string
    {
        return match ($this->category) {
            'client' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20 dark:bg-emerald-500/20 dark:text-emerald-400',
            'prospect' => 'bg-indigo-500/10 text-indigo-500 border-indigo-500/20 dark:bg-indigo-500/20 dark:text-indigo-400',
            'partner' => 'bg-amber-500/10 text-amber-500 border-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400',
            'colleague' => 'bg-sky-500/10 text-sky-500 border-sky-500/20 dark:bg-sky-500/20 dark:text-sky-400',
            default => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20 dark:bg-zinc-500/20 dark:text-zinc-400',
        };
    }

    /**
     * Get human label for category.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Get all meetings / sessions with this contact.
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }
}
