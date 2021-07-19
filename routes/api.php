<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiVideoController;
use App\Http\Controllers\api\ApiNoteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('video')->group(function () {
    Route::get('/list', [ApiVideoController::class,'index']);
    Route::get('{id}', [ApiVideoController::class,'getVideo']);
    Route::post('/', [ApiVideoController::class,'insertVideo']);
    Route::post('{id}/comment', [ApiVideoController::class,'insertComment']);
    Route::get('{id}/comment', [ApiVideoController::class,'getComments']);
    Route::put('{id}', [ApiVideoController::class,'index']);
    Route::delete('{id}', [ApiVideoController::class,'deleteVideo']);
    Route::delete('/comment/{id}', [ApiVideoController::class,'deleteComment']);
});

Route::prefix('note')->group(function () {
    Route::get('{androidId}/list', [ApiNoteController::class,'index']);
    Route::post('{androidId}/', [ApiNoteController::class,'insertNote']);
    Route::delete('{id}', [ApiNoteController::class,'deleteNote']);
});