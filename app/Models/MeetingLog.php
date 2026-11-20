<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingLog extends Model
{
    use HasFactory;

    public const CHANNEL_WHATSAPP = 'whatsapp';
    public const CHANNEL_CALL = 'call';
    public const CHANNEL_MEETING = 'meeting';
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_NOTE = 'note';

    public const CHANNELS = [
        self::CHANNEL_WHATSAPP => 'WhatsApp',
        self::CHANNEL_CALL => 'Panggilan Telepon',
        self::CHANNEL_MEETING => 'Tatap Muka / Rapat',
        self::CHANNEL_EMAIL => 'Email',
        self::CHANNEL_NOTE => 'Catatan Internal',
    ];

    public const SENTIMENT_POSITIVE = 'positive';
    public const SENTIMENT_NEUTRAL = 'neutral';
    public const SENTIMENT_OBJECTION = 'objection';
    public const SENTIMENT_NEGOTIATION = 'negotiation';

    public const SENTIMENTS = [
        self::SENTIMENT_POSITIVE => 'Positif / Tertarik',
        self::SENTIMENT_NEUTRAL => 'Netral / Menunggu',
        self::SENTIMENT_OBJECTION => 'Keberatan / Keraguan',
        self::SENTIMENT_NEGOTIATION => 'Negosiasi Alot / Syarat Baru',
    ];

    protected $fillable = [
        'meeting_id',
        'user_id',
        'channel',
        'sentiment',
        'content',
        'logged_at',
    ];

    protected function casts(): array
    {
        return [
            'logged_at' => 'datetime',
        ];
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getChannelLabelAttribute(): string
    {
        return self::CHANNELS[$this->channel] ?? ucfirst($this->channel);
    }

    public function getSentimentLabelAttribute(): string
    {
        return self::SENTIMENTS[$this->sentiment] ?? ucfirst($this->sentiment);
    }

    public function getSentimentBadgeClassAttribute(): string
    {
        return match ($this->sentiment) {
            self::SENTIMENT_POSITIVE => 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/60',
            self::SENTIMENT_OBJECTION => 'bg-rose-50 dark:bg-rose-950/40 text-rose-700 dark:text-rose-300 border-rose-200 dark:border-rose-800/60',
            self::SENTIMENT_NEGOTIATION => 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-800/60',
            default => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-700',
        };
    }
}
