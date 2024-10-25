<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
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

Route::get('/todo', function () {
    return view('todo');
})->middleware(['auth', 'verified'])->name('todo');

Route::middleware('auth')->group(function () {
    Route::post('/todo/{id}/pin', [TodoController::class, 'pin'])->name('todo.pin');
    Route::post('/todo/{id}/unpin', [TodoController::class, 'unpin'])->name('todo.unpin');
    Route::post('/todo/{id}/done', [TodoController::class, 'markAsDone'])->name('todo.done');
    Route::get('todo/filter', [TodoController::class, 'filter'])->name('todo.filter');
    Route::get('/todo/search', [TodoController::class, 'search']);
    Route::resource('todo', TodoController::class); // Resource route for CRUD operations
});


require __DIR__ . '/auth.php';
