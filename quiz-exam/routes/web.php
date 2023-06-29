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
    Route::get('/quiz/count', [QuizController::class, 'count']);
    Route::post('/quiz/create', [QuizController::class, 'storeQuiz']);
    Route::get('/quiz/{quiz_id}', [QuizController::class, 'get']);
    Route::get('/result/{sub_id}', [QuizController::class, 'getResultInfo']);
    Route::get('/questions/{quiz_id}', [QuizController::class, 'questions']);
    Route::get('/options/{quiz_id}', [QuizController::class, 'options']);
    Route::get('/matches/{quiz_id}', [QuizController::class, 'matches']);
    Route::get('/user/{id}', [UserController::class, 'get']);
    Route::get('/user/{id}/submissions', [UserController::class, 'getSubmissions']);

});

Route::prefix('quiz')->group(function () {
    Route::get('/take/{quiz_id}', [QuizController::class, 'take'])->middleware('auth');
    Route::get('/create', [QuizController::class, 'create'])->middleware('auth')->name('create');
    Route::post('/store', [QuizController::class, 'storeAnswer'])->middleware('auth');

    Route::get('/{quiz_id}', [QuizController::class, 'details']);
    Route::get('/result/{sub_id}', [QuizController::class, 'result']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [RegisterController::class, 'logout'])->name('logout');
    Route::post('/user/update', [HomeController::class, 'update'])->name('user.update');
    Route::post('/user/updatePassword', [HomeController::class, 'updatePassword'])->name('user.update.password');
    Route::get('/user/details', [UserController::class, 'index'])->name('user.details');
    Route::get('/user/sub', [UserController::class, 'submissions'])->name('user.sub');
    Route::redirect('/user/', '/user/details');
});
