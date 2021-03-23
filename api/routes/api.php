<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\youtubeController;
use App\Http\Controllers\news_updateController;
use App\Http\Controllers\forgotPasswordController;
use App\Http\Controllers\Register\RegisterController;
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
 Route::get('register', [RegisterController::class, 'register']);
// Route::get('register/{id}', [RegisterController::class, 'registerId']);
 Route::post('register1', [RegisterController::class, 'registerSave']);
// Route::put('register/{register}', [RegisterController::class, 'registerUpdate']);
// Route::delete('register/{register}', [RegisterController::class, 'registerDelete']);
Route::get('register1/verify/{token}', [RegisterController::class, 'verifyUser']);
Route::post('/login', [RegisterController::class, 'login'])->middleware('api');
Route::get('/login', function () {
    return view('login');
});
Route::post('contact', [contactController::class, 'contactSave']);
Route::get('userlist', [adminController::class, 'userlist']);
Route::get('total', [adminController::class, 'totaluser']);
Route::get('userlist/{type}', [adminController::class, 'searchaccounttype']);
Route::delete('userlist/{id}', [adminController::class, 'deleteuser']);
Route::put('userlist/{id}', [adminController::class, 'edituser']);
Route::put('link', [youtubeController::class, 'updateLink']);
Route::get('link', [youtubeController::class, 'getLink']);
Route::post('news', [news_updateController::class, 'newsUpdateSave']);
Route::get('news', [news_updateController::class, 'get_news']);
Route::delete('news/{id}', [news_updateController::class, 'delete_news']);
Route::put('news/{id}', [news_updateController::class, 'edit_news']);
Route::delete('newsall', [news_updateController::class, 'deleteall_news']);
Route::put('user/{id}', [userController::class, 'edit_user']);
Route::put('change_password/{id}', [userController::class, 'change_password']);
Route::get('user/{id}', [userController::class, 'registerId']);
Route::post('/forgot_password',[forgotPasswordController::class, 'forgot_password']);
Route::get('/forgot_password/{token}',[forgotPasswordController::class, 'forgot_page']);
Route::put('/forgot_password1/{id}',[forgotPasswordController::class, 'new_password']);






