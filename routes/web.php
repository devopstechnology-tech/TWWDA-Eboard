<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

//Auth::routes(['verify' => true]);
Route::view('{route?}', 'welcome')
    ->where('route', '(?!api|assets|sanctum).*');
Route::view('/login', 'welcome')
    ->name('web.citizen.login');
