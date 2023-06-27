<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('home');
// });

Route::get('/', [HomeController::class, 'index'])->name('index');


Route::get('/user/details', [HomeController::class, 'user'])->name('user.details');
Route::redirect('/user/', '/user/details');

Route::post('/user/update', [HomeController::class, 'update'])->name('user.update');
Route::post('/user/updatePassword', [HomeController::class, 'updatePassword'])->name('user.update.password');

Route::get('/register', [RegisterController::class, 'registerForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [RegisterController::class, 'loginForm']);
Route::post('/login', [RegisterController::class, 'login'])->name('login');

Route::get('/logout', [RegisterController::class, 'logout'])->name('logout');

Route::get('/api/quizzes', [QuizController::class, 'index']);
Route::get('/api/users/{id}', [UserController::class, 'getUserNameById']);

Route::get('/quizzes/{id}', [QuizController::class, 'details']);
