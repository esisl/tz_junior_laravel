<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;

Route::get('/test-resource', function () {
    // Создадим тестовую задачу
    $task = Task::create([
        'title' => 'Тест Resource',
        'description' => 'Проверка форматирования',
        'status' => 'pending'
    ]);

    // Тест 1: Одиночный ресурс
    echo "<h3>TaskResource (один):</h3>";
    echo "<pre>" . json_encode(new TaskResource($task), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";

    // Тест 2: Коллекция
    echo "<h3>TaskCollection (список):</h3>";
    echo "<pre>" . json_encode(new TaskCollection(Task::all()), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";

    // Очистка
    $task->delete();
});