<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['checkLogin'])->group(function () {
   
    Route::post('/add-board', [HomeController::class, 'addBoard'])->name('addBoard');
    Route::post('/add-new-member', [HomeController::class, 'addNewMember'])->name('addNewMember');
    Route::get('/board-group/{boardID}', [HomeController::class, 'BoardGroup'])->name('BoardGroup');
    Route::post('/post-message', [HomeController::class, 'postMessage'])->name('postmessage');
    Route::post('/add-new-task', [HomeController::class, 'addTask'])->name('addTask');
    
    Route::post('/updatetask', [HomeController::class, 'updateTask'])->name('updateTask');
    Route::post('/uptask', [HomeController::class, 'UpTask'])->name('UpTask');
    Route::post('/deletetask', [HomeController::class, 'deleteTasks'])->name('deleteTasks');
   
    Route::post('/deleteboard', [HomeController::class, 'deleteBoard'])->name('deleteBoard');

});

