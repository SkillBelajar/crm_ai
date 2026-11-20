<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAiSetting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_ai_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'base_url',
        'api_key',
        'model_name',
        'is_verified',
        'last_tested_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'api_key' => 'encrypted',
            'is_verified' => 'boolean',
            'last_tested_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the AI setting.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get normalized base URL without trailing slash.
     */
    public function getNormalizedBaseUrlAttribute(): string
    {
        return rtrim(trim($this->base_url ?? ''), '/');
    }
}
