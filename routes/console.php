<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

Artisan::command('ping', function () {
    $response = Http::get(env('GRAPPLE_MANAGER_URL') . '/ping');
    $this->comment($response->ok() ? 'ok' : 'not ok');
})->purpose('Check status of the manager')->hourly();

Artisan::command('sites', function () {
    $response = Http::get(env('GRAPPLE_MANAGER_URL') . '/ping');
})->purpose('Check status of the manager')->hourly();
