<?php

declare(strict_types=1);


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

//Auth::routes(['verify' => true]);
// Route::get('/test-mail', function () {
//     Mail::raw('Hello, this is a test mail!', function ($message) {
//         $message->to('felixnyachio@gmail.com')->subject('Test Mail');
//     });
//     return 'Mail sent!';
// });
Route::view('{route?}', 'welcome')
    ->where('route', '(?!api|assets|sanctum).*');
Route::view('/login', 'welcome')
    ->name('web.citizen.login');
