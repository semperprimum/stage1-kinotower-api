<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\FilmController;
use App\Http\Controllers\Api\V1\GenderController;
use App\Http\Controllers\Api\V1\RatingController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Api\V1\Review;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Protected Routs
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post("auth/signout", [AuthController::class, 'logout']);

    Route::get("/users/{user}", [UserController::class, 'show']);
    Route::put("/users", [UserController::class, 'update']);
    Route::delete("/users", [UserController::class, 'destroy']);

    Route::post("/users/{id}/reviews", [ReviewController::class, 'store']);
    Route::get("/users/{user}/reviews", [ReviewController::class, 'index']);
    Route::delete("/users/{user}/reviews/{review}", [ReviewController::class, 'destroy']);

    Route::post("/users/{user}/ratings", [RatingController::class, 'store']);
    Route::get("/users/{user}/ratings", [RatingController::class, 'index']);
    Route::delete("/users/{user}/ratings/{rating}", [RatingController::class, 'destroy']);
});

// Public Routes
Route::post("/auth/signup", [AuthController::class, "register"]);
Route::post("/auth/signin", [AuthController::class, "login"]);

Route::get("/films", [FilmController::class, "index"]);
Route::get("/films/{film}", [FilmController::class, "show"]);

Route::get("/films/{film}/reviews", [ReviewController::class, "show"]);

Route::get("/categories", [CategoryController::class, "index"]);

Route::get("/countries", [CountryController::class, "index"]);

Route::get("/genders", [GenderController::class, "index"]);
