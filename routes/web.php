<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Protocols\Models\Protocol;

Route::get('/', function () {
    return view('welcome');
});

