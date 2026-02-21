<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/meet/{room}', function ($room) {
    // Redirect to the Next.js app running on port 3000
    return redirect("http://localhost:3000/rooms/$room");
});
