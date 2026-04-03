<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Получить список всех задач
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return new TaskCollection($tasks);
    }

    /**
     * Получить одну задачу по ID
     */
    public function show(int $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        return new TaskResource($task);
    }

    /**
     * Создать новую задачу
     */
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'status'      => 'nullable|in:pending,in_progress,completed',
        ]);

        // Создание задачи
        $task = Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status'      => $validated['status'] ?? 'pending',
        ]);

        return response()->json([
            'success' => true,
            'data'    => new TaskResource($task),
        ], 201);
    }

    /**
     * Обновить задачу
     */
    public function update(Request $request, int $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        // Валидация
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'status'      => 'nullable|in:pending,in_progress,completed',
        ]);

        // Обновление
        $task->update($validated);

        return response()->json([
            'success' => true,
            'data'    => new TaskResource($task),
        ]);
    }

    /**
     * Удалить задачу
     */
    public function destroy(int $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ], 200);
    }
}