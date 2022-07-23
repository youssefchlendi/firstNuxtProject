<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\resetPassword\CodeCheckController;
use App\Http\Controllers\Auth\resetPassword\ForgotPasswordController;
use App\Http\Controllers\Auth\resetPassword\ResetPasswordController;
use App\Http\Controllers\LeaderController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\test;
use App\Http\Controllers\TroupeController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategorieMaterielController;
use App\Http\Controllers\DemandeMaterielController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\ResponsabilityController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UpdateProfileController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/profile', [AuthenticationController::class, 'profile']);
    Route::group(['prefix' => '/profile'], function () {
        Route::put('/image', [UpdateProfileController::class, 'updateImage']);
        Route::put('/all', [UpdateProfileController::class, 'updateProfile']);
    });
    Route::post('/sign-out', [AuthenticationController::class, 'logout']);
    Route::get('/test', [test::class, 'test']);

    Route::apiResource('leaders', LeaderController::class);

    Route::group(['prefix' => '/leaders'], function () {
        Route::put('/{id}/accept', [LeaderController::class, 'accept']);
        Route::put('/{id}/reject', [LeaderController::class, 'reject']);
    });
    Route::group(['prefix' => '/members'], function () {
        Route::put('/{id}/accept', [MembersController::class, 'accept']);
        Route::put('/{id}/reject', [MembersController::class, 'reject']);
        Route::group(['prefix' => '/subscriptions'], function () {
            Route::get('', [SubscriptionController::class, 'index']);
            Route::put('/a/accept', [SubscriptionController::class, 'accept']);
            Route::put('/r/reject', [SubscriptionController::class, 'reject']);
        });
    });
    Route::apiResource('members', MembersController::class);
    Route::apiResource('materiel', MaterielController::class);
    Route::apiResource('demande-materiel', DemandeMaterielController::class);
    Route::get('/sent-demande-materiel', [DemandeMaterielController::class, 'sentDemandes']);
    Route::put('/demande-materiel-qte', [DemandeMaterielController::class, 'setQuantity']);
    Route::delete('/demande-materiel-mat/{id}/{idmte}', [DemandeMaterielController::class, 'detachMateriel']);
    Route::put('/demande-materiel-status/{id}/{status}', [DemandeMaterielController::class, 'setStatus']);
    Route::group(['prefix' => '/troupes'], function () {
        Route::post('', [TroupeController::class, 'store']);
        Route::put('/{id}', [TroupeController::class, 'update']);
        Route::delete('/{id}', [TroupeController::class, 'destroy']);
    });
});

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::get('/unique/{id}', [AuthenticationController::class, 'unique']);

Route::group(['prefix' => '/roles'], function () {
    Route::get('/', [RoleController::class, 'index']);
});

Route::group(['prefix' => '/troupes'], function () {
    Route::get('/', [TroupeController::class, 'index']);
});

Route::group(['prefix' => '/responsablities'], function () {
    Route::get('/', [ResponsabilityController::class, 'index']);
});

Route::get('all-materiel', [MaterielController::class, 'all']);
Route::post('forgot-password',  ForgotPasswordController::class);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', ResetPasswordController::class);

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend/{email}', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('catmat', [CategorieMaterielController::class, 'test']);

Route::apiResource('categorie-materiel', CategorieMaterielController::class);
