<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard & 7-Day Tracker - MindControl CRM')]
class UserDashboard extends Component
{
    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return $this->redirect(route('admin.dashboard'));
        }
    }

    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $sevenDaysAgo = now()->subDays(7);

        // 1. Total Pertemuan (7 Hari)
        $totalMeetings7Days = $user->meetings()
            ->where('created_at', '>=', $sevenDaysAgo)
            ->count();

        // 2. Komitmen Tercapai (7 Hari) + Conversion Rate
        $committed7Days = $user->meetings()
            ->where('created_at', '>=', $sevenDaysAgo)
            ->where('status', Meeting::STATUS_COMMITTED)
            ->count();

        $conversionRate = $totalMeetings7Days > 0
            ? round(($committed7Days / $totalMeetings7Days) * 100)
            : 0;

        // 3. Menunggu Tindak Lanjut (< 24 Jam): Jumlah pertemuan berstatus draft
        $pendingFollowUpCount = $user->meetings()
            ->where('status', Meeting::STATUS_DRAFT)
            ->count();

        // 4. Total Kontak CRM
        $totalContacts = $user->contacts()->count();

        // Rasio Pertemuan Terkunci (sent + committed) dalam 7 hari terakhir
        $locked7Days = $user->meetings()
            ->where('created_at', '>=', $sevenDaysAgo)
            ->whereIn('status', [Meeting::STATUS_SENT, Meeting::STATUS_COMMITTED])
            ->count();

        $goalProgressPercent = $totalMeetings7Days > 0
            ? min(100, round(($locked7Days / $totalMeetings7Days) * 100))
            : 0;

        // Daftar Prioritas 24 Jam: Maksimal 5 pertemuan berstatus draft diurutkan dari contract_deadline_at terdekat
        $urgentMeetings = $user->meetings()
            ->with('contact')
            ->where('status', Meeting::STATUS_DRAFT)
            ->orderBy('contract_deadline_at', 'asc')
            ->limit(5)
            ->get();

        // Aktivitas & Komitmen Terbaru: 5 pertemuan terbaru berstatus sent atau committed
        $recentActivities = $user->meetings()
            ->with('contact')
            ->whereIn('status', [Meeting::STATUS_SENT, Meeting::STATUS_COMMITTED])
            ->latest('updated_at')
            ->limit(5)
            ->get();

        // Status Koneksi AI (BYOK)
        $aiSetting = $user->aiSetting;
        $isAiVerified = (bool) ($aiSetting && $aiSetting->is_verified);
        $aiModelName = $aiSetting?->model_name ?? 'Default';

        return view('livewire.user-dashboard', [
            'user' => $user,
            'totalMeetings7Days' => $totalMeetings7Days,
            'committed7Days' => $committed7Days,
            'conversionRate' => $conversionRate,
            'pendingFollowUpCount' => $pendingFollowUpCount,
            'totalContacts' => $totalContacts,
            'locked7Days' => $locked7Days,
            'goalProgressPercent' => $goalProgressPercent,
            'urgentMeetings' => $urgentMeetings,
            'recentActivities' => $recentActivities,
            'isAiVerified' => $isAiVerified,
            'aiModelName' => $aiModelName,
        ]);
    }
}
