<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController_old extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $user = Auth::user()->role;


            if ($user == 'Admin') {
                $query = Task::with(['user', 'creator'])
                    ->orderBy('created_at', 'desc');
            } else {
                $query = Task::where('user_id', $userId)
                    ->with(['user', 'creator'])
                    ->orderBy('created_at', 'desc');
            }

            $results = $query->get()->map(function ($item) {
                $status = $item->status;
                if ($status == 'todo') {
                    $status = 'To Do';
                } elseif ($status == 'inprogress') {
                    $status = 'In Progress';
                } elseif ($status == 'done') {
                    $status = 'Completed';
                } elseif ($status == 'due') {
                    $status = 'Over Due';
                }

                $createdByName = $item->creator ? $item->creator->name : 'N/A'; // If creator not found, return 'N/A'
                return [
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'status' => $status,
                    'priority' => $item->priority,
                    'created_by' => $createdByName,
                    'task_date' => $item->task_date,
                    'completed_at' => $item->completed_at ? Carbon::parse($item->completed_at)->format('Y-m-d H:i:s') : null,
                    'due_date' => $item->due_date ? Carbon::parse($item->due_date)->format('Y-m-d') : null,
                    'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y-m-d H:i:s') : null,
                    'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y-m-d H:i:s') : null,
                    'user_name' => $item->user->name,
                ];
            })->toArray();
            return view('managetask.view', compact('results'));
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function addTask()
    {
        try {
            if (Auth::check() && Auth::user()->role == 'Admin') {
                $users = User::select('id', 'name')->distinct()->get();
            } else {
                $users = User::select('id', 'name')->where('id', Auth::id())->get();
            }
            $html = view('managetask.add', compact('users'))->render();
            return response()->json(['html' => $html, 'success' => true]);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function postTask(TaskRequest $request)
    {
        try {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->user_id = $request->user_id;
            $task->due_date = $request->due_date;
            $task->created_by = Auth::id();
            $task->save();
            return back()->with('success', 'Task Created Successfully');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function editTask(Request $request)
    {
        try {
            $id = $request->id;
            $data = Task::find($id);
            if (Auth::check() && Auth::user()->role == 'Admin') {
                $users = User::select('id', 'name')->distinct()->get();
            } else {
                $users = User::select('id', 'name')->where('id', Auth::id())->get();
            }
            $html = view('managetask.editTask', compact('data', 'users'))->render();
            return response()->json(['html' => $html, 'success' => true]);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function updateTask(TaskRequest $request)
    {
        try {
            $task = Task::find($request->id_edit);
            $task->title = $request->title;
            $task->due_date = $request->due_date;
            $task->description = $request->description;
            $task->user_id = $request->user_id;
            $task->priority = $request->priority;
            $task->update();
            return back()->with('success', 'Task Updated Successfully');
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function deleteTask(Request $request)
    {
        try {
            $delete = Task::where('id', $request->id)->delete();
            if ($delete) {
                return response()->json(['message' => 'Task Deleted Succesfully', 'status' => 'success']);
            }
            return response()->json(['message' => 'Task Deleted Failed', 'status' => 'error']);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }
}
