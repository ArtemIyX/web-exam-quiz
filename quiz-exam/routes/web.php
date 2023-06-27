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

Route::get('/register', [RegisterController::class, 'registerForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [RegisterController::class, 'loginForm']);
Route::post('/login', [RegisterController::class, 'login'])->name('login');

Route::prefix('api')->group(function() {
    Route::get('/quizzes', [QuizController::class, 'index']);
    Route::get('/result/{sub_id}', [QuizController::class, 'getResultInfo']);
    Route::get('/questions/{quiz_id}', [QuizController::class, 'questions']);
    Route::get('/options/{quiz_id}', [QuizController::class, 'options']);
    Route::get('/matches/{quiz_id}', [QuizController::class, 'matches']);
    Route::get('/users/{id}', [UserController::class, 'getUserNameById']);
});

Route::prefix('quiz')->group(function () {
    Route::get('/{quiz_id}', [QuizController::class, 'details']);
    Route::get('/take/{quiz_id}', [QuizController::class, 'take']);
    Route::post('/store', [QuizController::class, 'storeAnswer']);
    Route::get('/result/{sub_id}', [QuizController::class, 'result']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [RegisterController::class, 'logout'])->name('logout');

    Route::post('/user/update', [HomeController::class, 'update'])->name('user.update');
    Route::post('/user/updatePassword', [HomeController::class, 'updatePassword'])->name('user.update.password');
    Route::get('/user/details', [HomeController::class, 'user'])->name('user.details');
    Route::redirect('/user/', '/user/details');
});
