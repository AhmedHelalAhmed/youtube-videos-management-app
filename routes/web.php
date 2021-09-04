<?php

use App\Http\Controllers\IndexingChannelController;
use App\Http\Controllers\ShowingChannelController;
use App\Http\Controllers\StoringChannelController;
use App\Http\Controllers\SyncVideosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])
    ->get('/channels', IndexingChannelController::class)
    ->name('channels.index');
Route::middleware(['auth:sanctum', 'verified'])
    ->post('/channels', StoringChannelController::class)
    ->name('channels.store');
Route::middleware(['auth:sanctum', 'verified'])
    ->get('/channels/{channel}', ShowingChannelController::class)
    ->name('channels.show');
Route::middleware(['auth:sanctum', 'verified'])
    ->post('/channels/{channel}/sync-videos', SyncVideosController::class)
    ->name('channels.show.sync-videos');
