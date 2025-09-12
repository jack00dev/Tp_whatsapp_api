<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DiscussionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [AuthController::class, "tokenLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

Route::apiResource("/users", UserController::class)->except(["create", "store", "show", "edit", "update", "destroy"]);
Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource("/contacts", ContactController::class)->except(["create", "edit"]);
    Route::apiResource("/discussions", DiscussionController::class)->except(["create", "edit"]);

    Route::post("/logout", [AuthController::class, "logout"]);
});
