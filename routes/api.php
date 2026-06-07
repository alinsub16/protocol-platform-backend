<?php

use Illuminate\Support\Facades\Route;
use App\Domain\Protocols\Models\Protocol;
use App\Domain\Threads\Models\Thread;
use App\Domain\Comments\Models\Comment;
use App\Domain\Votes\Models\Vote;
use App\Domain\Reviews\Models\Review;

use App\Domain\Protocols\Controllers\ProtocolController;
use App\Domain\Threads\Controllers\ThreadController;
use App\Domain\Comments\Controllers\CommentController;
use App\Domain\Votes\Controllers\VoteController;
use App\Domain\Reviews\Controllers\ReviewController;

// Thread Route
Route::prefix('threads')->group(function () {
    Route::get('/', [ThreadController::class, 'index']);
    Route::get('/{thread}', [ThreadController::class, 'show']);
    Route::post('/', [ThreadController::class, 'store']);
});

// Comment Route
Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index']);
    Route::post('/', [CommentController::class, 'store']);
});

// Vote Route
Route::post('/vote', [VoteController::class, 'store']);

// Protocol Route
Route::prefix('protocols')->group(function () {
    Route::get('/', [ProtocolController::class, 'index']);
    Route::get('/{protocol}', [ProtocolController::class, 'show']);
    Route::post('/', [ProtocolController::class, 'store']);

    Route::get('/{protocol}/threads', [ProtocolController::class, 'threads']);
});

// Review Route
Route::prefix('reviews')->group(function () {
    Route::post('/', [ReviewController::class, 'store']);
    Route::put('/{review}', [ReviewController::class, 'update']);
    Route::delete('/{review}', [ReviewController::class, 'destroy']);
});

Route::get( '/protocols/{protocol}/reviews', [ReviewController::class, 'index'] );

Route::get('/search/protocols', [ProtocolController::class, 'search']);

Route::get('/search/threads', [ThreadController::class, 'search']);


