<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;


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

Route::redirect('/', '/todo');
Route::post('/todo/{id}/pin', [TodoController::class, 'pin'])->name('todo.pin');
Route::post('/todo/{id}/unpin', [TodoController::class, 'unpin'])->name('todo.unpin');
Route::post('/todo/{id}/done', [TodoController::class, 'markAsDone'])->name('todo.done');
Route::resource('todo', TodoController::class);








//routes/web.php
