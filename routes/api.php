<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::match(
    methods: ['get', 'post'],
    uri: 'parse-auto',
    action: static fn() => \Artisan::call(\App\Console\Commands\ParseAuto::class)
);
