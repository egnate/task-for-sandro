<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Account\Notes\Index as NotesIndex;
use App\Livewire\Account\Notes\Create as NotesCreate;
use App\Livewire\Account\Notes\Edit as NotesEdit;
use App\Livewire\Account\ApiTokens;
use App\Livewire\Public\PublicNote;

// Authentication routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Public routes
Route::get('/p/{slug}', PublicNote::class)->name('public.note');

// Protected account routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('notes.index');
    });

    // Notes routes
    Route::get('/notes', NotesIndex::class)->name('notes.index');
    Route::get('/notes/create', NotesCreate::class)->name('notes.create');
    Route::get('/notes/{note}/edit', NotesEdit::class)->name('notes.edit');

    // API Tokens route
    Route::get('/api-tokens', ApiTokens::class)->name('api-tokens');
});
