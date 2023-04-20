<?php

use App\Models\Admin;
use App\Models\User;
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

Route::get('/', function () {
    //$admin=User::all();
    //return $admin;
    return ['Laravel' => app()->version()];
});
Route::get('/dashbord', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
