<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
Route::post('/upload', [\App\Http\Controllers\UploadController::class,'upload']);
Route::post('sociallogin/{provider}', [\App\Http\Controllers\AuthController::class,'SocialSignup']);

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::resource('chat',\App\Http\Controllers\ChatController::class);
    Route::post('/me', [\App\Http\Controllers\UserController::class,'me']);
    Route::post('/logout', [\App\Http\Controllers\UserController::class,'logout']);
    Route::resource('/user',\App\Http\Controllers\UserController::class);
    Route::post('/uppassword',[\App\Http\Controllers\UserController::class,'uppassword']);
    Route::resource('/categoria',\App\Http\Controllers\CategoriaController::class);
    Route::resource('/producto',\App\Http\Controllers\ProductoController::class);
    Route::resource('/sale',\App\Http\Controllers\SaleController::class);
    Route::post('consultsale',[\App\Http\Controllers\SaleController::class,'consultSale']);
    Route::post('listaperfil',[\App\Http\Controllers\ProfileController::class,'listaperfil']);
    Route::post('listpersonal',[\App\Http\Controllers\UserController::class,'listpersonal']);
    Route::resource('/cliente',\App\Http\Controllers\ClienteController::class);
    Route::resource('/provider',\App\Http\Controllers\ProviderController::class);
    Route::resource('/profile',\App\Http\Controllers\ProfileController::class);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
});
