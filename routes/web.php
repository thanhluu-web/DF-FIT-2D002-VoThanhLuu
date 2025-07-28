<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return view('dashboard',compact('role'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('unauthorized', function(){
    return view('unauthorized');
})->name('unauthorized');

Route::get('comming-soon', function(){
    return view('comming_soon');
})->name('comming_soon');


require __DIR__.'/auth.php';
require __DIR__.'/admin_routes.php';
require __DIR__.'/staff_routes.php';


