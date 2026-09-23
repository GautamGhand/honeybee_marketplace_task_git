<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\LocationApiController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listing/{slug}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/category/{categorySlug}', [ListingController::class, 'byCategory'])->name('listings.category');
Route::get('/city/{citySlug}', [ListingController::class, 'byCity'])->name('listings.city');
Route::get('/city/{citySlug}/{categorySlug}', [ListingController::class, 'byCityAndCategory'])->name('listings.city.category');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Auth routes (authenticated)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/post-ad', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/post-ad', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/my-listings', [ListingController::class, 'myListings'])->name('listings.mine');
});

// API routes for cascading dropdowns
Route::get('/api/states/{country}', [LocationApiController::class, 'getStates'])->name('api.states');
Route::get('/api/cities/{state}', [LocationApiController::class, 'getCities'])->name('api.cities');
Route::get('/api/areas/{city}', [LocationApiController::class, 'getAreas'])->name('api.areas');
Route::get('/api/subcategories/{category}', [CategoryApiController::class, 'getSubcategories'])->name('api.subcategories');
