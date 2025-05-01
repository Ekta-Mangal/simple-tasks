<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // List all tasks (GET /api/tasks)
    public function index(Request $request)
    {
        try {
            $tasks = Task::with(['user.contact.country'])
                ->latest()
                ->get();

            $formattedTasks = $tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'user' => [
                        'name' => $task->user->name ?? 'Unknown',
                        'email' => $task->user->email ?? 'N/A',
                        'country' => [
                            'name' => $task->user->contact->country->name ?? 'N/A',
                            'code' => $task->user->contact->country->code ?? 'N/A',
                        ],
                    ],
                    'description' => $task->description ?? 'No description provided',
                    'status' => $task->status ?? 'todo',
                    'priority' => $task->priority ?? 'Medium',
                    'task_date' => $task->task_date ? Carbon::parse($task->task_date)->toIso8601String() : null,
                    'completed_at' => $task->completed_at ? Carbon::parse($task->completed_at)->toIso8601String() : null,
                    'created_at' => Carbon::parse($task->created_at)->toIso8601String(),
                    'due_date' => $task->due_date ? Carbon::parse($task->due_date)->toIso8601String() : null,
                ];
            });

            if ($formattedTasks->isEmpty()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'No tasks found!',
                ], 200);
            }

            return response()->json(['data' => $formattedTasks], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority ?? 'Medium';
            $task->status = $request->status ?? 'todo';
            $task->user_id = $request->user_id;
            $task->due_date = $request->due_date ? Carbon::parse($request->due_date)->toDateString() : null;
            $task->created_by = Auth::id();
            $task->save();

            $taskWithRelations = Task::with(['user.contact.country'])->find($task->id);

            return response()->json([
                'success' => 'Task Created Successfully',
                'task' => [
                    'id' => $taskWithRelations->id,
                    'title' => $taskWithRelations->title,
                    'description' => $taskWithRelations->description,
                    'status' => $taskWithRelations->status,
                    'priority' => $taskWithRelations->priority,
                    'task_date' => $taskWithRelations->task_date ? Carbon::parse($taskWithRelations->task_date)->toIso8601String() : null,
                    'due_date' => $taskWithRelations->due_date ? Carbon::parse($taskWithRelations->due_date)->toIso8601String() : null,
                    'user' => [
                        'name' => $taskWithRelations->user->name ?? 'Unknown',
                        'email' => $taskWithRelations->user->email ?? 'N/A',
                        'country' => [
                            'name' => $taskWithRelations->user->contact->country->name ?? 'N/A',
                            'code' => $taskWithRelations->user->contact->country->code ?? 'N/A',
                        ],
                    ],
                    'created_at' => Carbon::parse($taskWithRelations->created_at)->toIso8601String(),
                ],
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    // Update task (PUT /api/tasks/{id})
    public function update(TaskRequest $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->user_id = $request->user_id;
            $task->due_date = $request->due_date;
            $task->save();

            $user = $task->user()->with('contact.country')->first();

            $updatedTask = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'priority' => $task->priority,
                'status' => $task->status ?? 'todo',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'country' => [
                        'name' => $user->contact->country->name ?? 'N/A',
                    ],
                ],
                'due_date' => $task->due_date ? Carbon::parse($task->due_date)->toIso8601String() : null,
                'updated_at' => Carbon::parse($task->updated_at)->toIso8601String(),
            ];

            return response()->json(['success' => 'Task Updated Successfully', 'task' => $updatedTask], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'message' => $e->getMessage()], 500);
        }
    }

    // Delete task (DELETE /api/tasks/{id})
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json(['success' => 'Task Deleted Successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task Not Found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
}