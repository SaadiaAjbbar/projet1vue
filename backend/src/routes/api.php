<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\FavoriteController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{questionId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/test', function () {
    return ['message' => 'API Works Laravel 12'];
})->middleware('auth:sanctum');

Route::post('/Createquestion', [QuestionController::class, 'store'])->name('Createquestion')->middleware('auth:sanctum');

Route::get('/listeQuestions', [QuestionController::class, 'index'])->name('listeQuestions')->middleware('auth:sanctum');

Route::put('/updateQuestion/{id}', [QuestionController::class, 'update'])->name('updateQuestion')->middleware('auth:sanctum');
Route::delete('/deleteQuestion/{id}', [QuestionController::class, 'destroy'])->name('deleteQuestion')->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::post('/CreateResponse', [ResponseController::class, 'store'])->name('CreateResponse')->middleware('auth:sanctum');
Route::get('/listeResponses', [ResponseController::class, 'index'])->name('listeResponses')->middleware('auth:sanctum');
Route::put('/updateResponse/{id}', [ResponseController::class, 'update'])->name('updateResponse')->middleware('auth:sanctum');
Route::delete('/deleteResponse/{id}', [ResponseController::class, 'destroy'])->name('deleteResponse')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{questionId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

});
