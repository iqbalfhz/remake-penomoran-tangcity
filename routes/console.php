<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reset nomor urut setiap tanggal 1 Januari pukul 00:00
Schedule::command('nomor:reset --force')
    ->yearlyOn(1, 1, '00:00')
    ->withoutOverlapping()
    ->runInBackground();
