<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Societe\SocieteController;
use App\Http\Controllers\User\InvitController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/get-invit-by/{token}',[InvitController::class, 'getInvit']);
Route::post('/store-new-employe',[UserController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {   
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users/admin',[UserController::class, 'admins'])->name('users.admin');
    Route::apiResource('users', UserController::class);
    Route::apiResource('societes', SocieteController::class);
    Route::apiResource('invits', InvitController::class);


    
    // Route::prefix('administration')->group(function () {
    //     Route::get(
    //         '/users',
    //         [AdminController::class, 'index']
    //     )->name('admin.index');
    //     Route::get(
    //         '/users/{admin}',
    //         [AdminController::class, 'show']
    //     )->name('admin.show');
    // });
});