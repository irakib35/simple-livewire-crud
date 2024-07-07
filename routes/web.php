<?php

use App\Livewire\PostComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', PostComponent::class)->name('posts');