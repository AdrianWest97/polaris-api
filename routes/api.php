<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PreAlertController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Models\PickUpLocation;
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

define('DELETE_QUERY','/delete/{id}');

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'user'], function () {
     Route::get('/', function (Request $request) {
         return $request->user();
      });
      Route::get('/activity',[UserController::class,'get_packages_payments_prealerts']);
      Route::get('/pre_alerts',[UserController::class,'pre_alerts']);
      Route::delete(DELETE_QUERY,[UserController::class,'delete']);
    });

    Route::get('email/verify/{hash}', [VerificationController::class,'verify'])->name('verification.verify');

        Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');

        Route::group(['prefix' => 'users'], function () {
        Route::get('/',[UserController::class,'all']);
        });

        Route::group(['prefix' => 'settings'], function () {
        Route::get('/',[SettingsController::class,'all']);
        Route::put('/save_location',[SettingsController::class,'save_location']);
        Route::delete('/delete_location/{id}',[SettingsController::class,'delete_location']);
        Route::delete('/delete_us_address/{id}',[SettingsController::class,'delete_us_address']);
        Route::put('/save_us_address',[SettingsController::class,'save_us_address']);
        Route::put('/package_status',[StatusController::class,'store']);

        });

        Route::group(['prefix' => 'pre_alerts'], function () {
            Route::get('/',[PreAlertController::class,'all']);
            Route::put('/create',[PreAlertController::class,'store']);
            Route::put('/update/{id}',[PreAlertController::class,'update_status']);
            Route::delete(DELETE_QUERY,[PreAlertController::class,'delete']);
        });


    Route::group(['prefix' => 'package'], function () {
        Route::put('/create',[PackageController::class,'store']);
        Route::get('/',[PackageController::class,'all']);
        Route::delete(DELETE_QUERY,[PackageController::class,'delete']);
    });

            Route::group(['prefix' => 'payments'], function () {
            Route::get('/',[PaymentController::class,'all']);
            Route::put('/create',[PaymentController::class,'create']);
            Route::delete(DELETE_QUERY,[PaymentController::class,'delete']);
        });
        Route::get('/statuses',[StatusController::class,'all']);
        Route::get('/categories',[CategoryController::class,'all']);

         Route::group(['prefix' => 'products'], function () {
        Route::post('/store/',[ProductController::class,'store']);
        Route::put('/set_visibility',[ProductController::class,'set_visibility']);
        Route::put('/set_featured',[ProductController::class,'set_featured']);
        Route::delete(DELETE_QUERY,[ProductController::class,'delete']);
    });

    //logout user
    Route::post('/logout', [LoginController::class,'logout']);
}); //end auth:api middleware


Route::post('/login', [LoginController::class,'login']);
Route::post('/register', [RegisterController::class,'register']);
Route::post('/password/email',[ForgotPasswordController::class,'sendResetLinkEmail']);
Route::post('/password/reset',[ResetPasswordController::class,'reset']);
Route::get('/pick_up_locations',function(){
   return PickUpLocation::all();
 });
 Route::get('/products/',[ProductController::class,'all']);
Route::get('/products/{id}',[ProductController::class,'get']);
Route::get('/packages/',[PackageController::class,'all']);
