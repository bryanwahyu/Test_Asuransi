<?php

use App\Http\Controllers\FriendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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

Route::prefix('v1')->group(function () {
    Route::prefix('friend')->group(function(){
        Route::post('add',[FriendController::class,"request_friend"]);
        Route::get('accept',[FriendController::class,'change_accept_or_rejection']);
        Route::get('/',[FriendController::class,'index']);
        Route::get('requestor',[FriendController::class,"list_of_friend_status"]);

    });
    Route::get('/migrate', function () {
        Artisan::call('migrate');
        return Artisan::output();
    });
});
