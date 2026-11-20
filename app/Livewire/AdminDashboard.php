<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use App\Models\UserAiSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Panel Admin SaaS - MindControl CRM')]
class AdminDashboard extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all'; // all, active, suspended
    public ?string $flashMessage = null;
    public string $flashType = 'success'; // success, error

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function dismissFlash(): void
    {
        $this->flashMessage = null;
    }

    public function toggleUserStatus(int $userId): void
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($currentUser->id === $userId) {
            $this->flashMessage = 'Tindakan ditolak: Anda tidak dapat menonaktifkan akun Anda sendiri.';
            $this->flashType = 'error';
            return;
        }

        $targetUser = User::find($userId);
        if (!$targetUser) {
            $this->flashMessage = 'Pengguna tidak ditemukan dalam sistem.';
            $this->flashType = 'error';
            return;
        }

        if ($targetUser->isAdmin()) {
            $this->flashMessage = 'Tindakan ditolak: Akun dengan role Administrator tidak dapat dinonaktifkan.';
            $this->flashType = 'error';
            return;
        }

        $targetUser->is_active = !$targetUser->is_active;
        $targetUser->save();

        $statusName = $targetUser->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (suspended)';
        $this->flashMessage = "Status akun {$targetUser->name} berhasil {$statusName}.";
        $this->flashType = 'success';
    }

    public function render()
    {
        // 1. Total Pengguna (role = user) + jumlah aktif
        $totalRegularUsers = User::where('role', 'user')->count();
        $activeRegularUsers = User::where('role', 'user')->where('is_active', true)->count();

        // 2. AI Terkonfigurasi: jumlah user yang sudah menyimpan setting AI
        $totalAiConfigured = UserAiSetting::where('is_verified', true)
            ->orWhereNotNull('api_key')
            ->count();

        // 3. Total Kontak CRM global
        $totalContacts = Contact::count();

        // 4. Total Sesi 3 Misi global + persentase committed
        $totalMeetings = Meeting::count();
        $committedMeetings = Meeting::where('status', Meeting::STATUS_COMMITTED)->count();
        $conversionRate = $totalMeetings > 0
            ? (int) round(($committedMeetings / $totalMeetings) * 100)
            : 0;

        // Query Daftar Pengguna dengan Eager Loading & Count
        $usersQuery = User::with(['aiSetting'])
            ->withCount(['contacts', 'meetings'])
            ->latest();

        if (!empty($this->search)) {
            $term = trim($this->search);
            $usersQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        if ($this->statusFilter === 'active') {
            $usersQuery->where('is_active', true);
        } elseif ($this->statusFilter === 'suspended') {
            $usersQuery->where('is_active', false);
        }

        $users = $usersQuery->paginate(10);

        return view('livewire.admin-dashboard', [
            'totalRegularUsers' => $totalRegularUsers,
            'activeRegularUsers' => $activeRegularUsers,
            'totalAiConfigured' => $totalAiConfigured,
            'totalContacts' => $totalContacts,
            'totalMeetings' => $totalMeetings,
            'committedMeetings' => $committedMeetings,
            'conversionRate' => $conversionRate,
            'users' => $users,
        ]);
    }
}
