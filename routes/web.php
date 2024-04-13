<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskManagement\Ajax\TaskController;
use App\Http\Controllers\TaskManagement\Ajax\ProjectController;

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
    return view('pages.home');
})->name('home');

//project resource url
Route::resource('projects', ProjectController::class)->except([
    'create',
    'show',
    'edit',
    'update',
    'destroy',
]);

//task index url
Route::get('/tasks/{project}', [TaskController::class, 'index']);

//task create url
Route::post('/tasks/{project}', [TaskController::class, 'store']);

//task update url
Route::put('/tasks/{task}', [TaskController::class, 'update']);

//task delete url
Route::post('/delete-tasks/{task}', [TaskController::class, 'destroy']);

//update task order url
Route::post('/update-tasks-order', [TaskController::class, 'updateOrder']);
