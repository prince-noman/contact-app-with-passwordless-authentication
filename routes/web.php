<?php

use App\Actions\CreateUser;
use App\Actions\SendMagicLink;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ContactController;



Route::get('/', function () {
    return view('home');
});


Route::view('auth/login', 'auth.login')->middleware('guest')->name('login');
Route::post('auth/login', SendMagicLink::class)->name('auth.login')->middleware('guest');

Route::get('auht/session/{user:email}', LoginController::class)->name('auth.session')->middleware('signed', 'guest');

Route::view('/auth/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/auth/register', CreateUser::class)->name('auth.register')->middleware('guest');



Route::get('/contacts', function () {
    return view('welcome');
})->name('home');

// Contact Routes
Route::controller(ContactController::class)
    ->prefix('contacts')
    ->as('contacts.')
    ->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}/update', 'update')->name('update');
        Route::delete('/{id}/delete', 'destroy')->name('delete');
    });