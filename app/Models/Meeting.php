<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SENT = 'sent';
    public const STATUS_COMMITTED = 'committed';
    public const STATUS_FAILED = 'failed';

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_SENT => 'Sudah Dikirim',
        self::STATUS_COMMITTED => 'Komitmen Tercapai',
        self::STATUS_FAILED => 'Gagal / Batal',
    ];

    protected $fillable = [
        'user_id',
        'contact_id',
        'title',
        'meeting_date',
        'biggest_need',
        'ego_validation_note',
        'user_goal',
        'context_notes',
        'ai_conditional_yes',
        'ai_psychological_contract',
        'contract_deadline_at',
        'status',
        'commitment_result',
        'latest_ai_strategy',
        'latest_ai_strategy_at',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'datetime',
            'contract_deadline_at' => 'datetime',
            'latest_ai_strategy_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Meeting $meeting) {
            if (! $meeting->contract_deadline_at) {
                $baseDate = $meeting->meeting_date ? Carbon::parse($meeting->meeting_date) : now();
                $meeting->contract_deadline_at = $baseDate->copy()->addHours(24);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(MeetingLog::class)->orderBy('logged_at', 'desc');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_COMMITTED => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
            self::STATUS_SENT => 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20',
            self::STATUS_FAILED => 'bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 border-zinc-500/20',
            default => 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20',
        };
    }

    /**
     * Menghitung status batas 24 Jam sistem internal.
     */
    public function getDeadlineInfo(): array
    {
        if ($this->status === self::STATUS_COMMITTED) {
            return [
                'status' => 'committed',
                'label' => 'Komitmen Tercapai',
                'badge' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                'is_overdue' => false,
            ];
        }

        if ($this->status === self::STATUS_SENT) {
            return [
                'status' => 'sent',
                'label' => 'Pesan Terkirim',
                'badge' => 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20',
                'is_overdue' => false,
            ];
        }

        if ($this->status === self::STATUS_FAILED) {
            return [
                'status' => 'failed',
                'label' => 'Batal / Gagal',
                'badge' => 'bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 border-zinc-500/20',
                'is_overdue' => false,
            ];
        }

        // Status Draft: hitung sisa batas waktu 24 jam
        if (! $this->contract_deadline_at) {
            return [
                'status' => 'unknown',
                'label' => 'Batas Waktu Belum Ditentukan',
                'badge' => 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20',
                'is_overdue' => false,
            ];
        }

        if (now()->gt($this->contract_deadline_at)) {
            $diff = now()->diffForHumans($this->contract_deadline_at, ['syntax' => CarbonInterface::DIFF_ABSOLUTE, 'parts' => 1]);
            return [
                'status' => 'expired',
                'label' => "Lewat {$diff}",
                'badge' => 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border-rose-500/20',
                'is_overdue' => true,
            ];
        }

        $remainingHours = now()->diffInHours($this->contract_deadline_at);
        $diff = now()->diffForHumans($this->contract_deadline_at, ['syntax' => CarbonInterface::DIFF_ABSOLUTE, 'parts' => 1]);

        $badge = $remainingHours <= 6
            ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20'
            : 'bg-zinc-500/10 text-zinc-600 dark:text-zinc-400 border-zinc-500/20';

        return [
            'status' => 'active',
            'label' => "Sisa {$diff}",
            'badge' => $badge,
            'is_overdue' => false,
        ];
    }
}
