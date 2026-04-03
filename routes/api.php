<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Здесь регистрируются маршруты для вашего REST API.
| Префикс /api/ добавляется автоматически.
|
*/

// CRUD маршруты для задач
Route::apiResource('tasks', TaskController::class);