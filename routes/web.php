<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/{any?}', function ($any = null) {
    // If it's a request for a specific file in the admin folder
    $path = public_path("admin/$any");
    if ($any && file_exists($path) && !is_dir($path)) {
        return response()->file($path);
    }
    
    // Otherwise, serve the SPA index
    return response()->file(public_path('admin/index.html'));
})->where('any', '.*');
