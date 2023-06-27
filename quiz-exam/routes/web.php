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

Route::prefix('api')->group(function() {
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::get('/quiz/{id}', [QuizController::class, 'questions']);
    Route::get('/question/{id}', [QuizController::class, 'options']);
    Route::get('/users/{id}', [UserController::class, 'getUserNameById']);
});

Route::prefix('quiz')->group(function () {
    Route::get('/{id}', [QuizController::class, 'details']);
    Route::get('/take/{quiz_id}', [QuizController::class, 'take']);
    Route::post('/{quiz_id}', [QuizController::class, 'storeAnswer']);
});
