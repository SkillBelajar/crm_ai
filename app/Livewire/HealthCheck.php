<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class HealthCheck extends Component
{
    public bool $dbConnected = false;
    public string $dbMessage = 'Checking...';

    public bool $redisConnected = false;
    public string $redisMessage = 'Checking...';

    public string $serverStatus = 'Laravel 13 + Octane Ready';
    public string $phpVersion = '';
    public string $octaneServer = '';
    public string $checkedAt = '';

    public function mount(): void
    {
        $this->checkHealth();
    }

    public function checkHealth(): void
    {
        // Database Check
        try {
            DB::connection()->getPdo();
            $driver = DB::connection()->getDriverName();
            $this->dbConnected = true;

            if ($driver === 'mysql') {
                $dbVersion = DB::select('SELECT VERSION() as v')[0]->v ?? '8.0';
                $this->dbMessage = 'Connected (MySQL ' . $dbVersion . ')';
            } elseif ($driver === 'sqlite') {
                $dbVersion = DB::select('SELECT sqlite_version() as v')[0]->v ?? '';
                $this->dbMessage = 'Connected (SQLite ' . $dbVersion . ')';
            } else {
                $this->dbMessage = 'Connected (' . ucfirst($driver) . ')';
            }
        } catch (\Throwable $e) {
            $this->dbConnected = false;
            $this->dbMessage = 'Error: ' . $e->getMessage();
        }

        // Redis Check
        try {
            $pong = Redis::ping();
            $this->redisConnected = true;
            $this->redisMessage = 'Connected (PONG)';
        } catch (\Throwable $e) {
            $this->redisConnected = false;
            $this->redisMessage = 'Error: ' . $e->getMessage();
        }

        $this->phpVersion = PHP_VERSION;
        $this->octaneServer = config('octane.server', 'frankenphp');
        $this->checkedAt = now()->format('Y-m-d H:i:s T');
    }

    public function render()
    {
        return view('livewire.health-check');
    }
}
