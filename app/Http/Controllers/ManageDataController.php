<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ManageDataController extends Controller
{
    public function gettabledata(Request $request)
    {
        try {
            $id = $request->input('id');
            $userId = Auth::user()->id;
            $user = Auth::user()->role;

            if ($user == 'Admin') {
                if ($id == '0') {
                    $colour = "info";
                    $query = Task::with('user')
                        ->where('status', 'todo')
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '1') {
                    $colour = "success";
                    $query = Task::with('user')
                        ->where('status', 'done')
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '2') {
                    $colour = "warning";
                    $query = Task::with('user')
                        ->where('status', 'inprogress')
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '3') {
                    $colour = "danger";
                    $query = Task::with('user')
                        ->where('status', 'due')
                        ->orderBy('created_at', 'asc');
                } else {
                    $query = Task::whereRaw('0');
                }
            } else {
                if ($id == '0') {
                    $colour = "info";
                    $query = Task::where('status', 'todo')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '1') {
                    $colour = "success";
                    $query = Task::where('status', 'done')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '2') {
                    $colour = "warning";
                    $query = Task::where('status', 'inprogress')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'asc');
                } elseif ($id == '3') {
                    $colour = "danger";
                    $query = Task::where('status', 'due')
                        ->where('user_id', $userId)
                        ->orderBy('created_at', 'asc');
                } else {
                    $query = Task::whereRaw('0');
                }
            }

            $results = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'task_date' => $item->task_date ? Carbon::parse($item->task_date)->format('Y-m-d H:i:s') : null,
                    'completed_at' => $item->completed_at ? Carbon::parse($item->completed_at)->format('Y-m-d H:i:s') : null,
                    'due_date' => $item->due_date ? Carbon::parse($item->due_date)->format('Y-m-d') : null,
                    'created_at' => $item->created_at ? Carbon::parse($item->created_at)->format('Y-m-d H:i:s') : null,
                    'updated_at' => $item->updated_at ? Carbon::parse($item->updated_at)->format('Y-m-d H:i:s') : null,
                    'user_name' => $item->user ? $item->user->name : 'N/A',
                ];
            })->toArray();

            if (sizeof($results) > 0) {
                $html = view('managedata.tableData', compact('id', 'results', 'colour'))->render();

                // Add JavaScript code to reload the page
                $javascript = "<script>window.location.reload();</script>";

                return response()->json(['message' => 'Data found', 'html' => $html, 'javascript' => $javascript, 'status' => true], 200);
            } else {
                return response()->json(['message' => 'Data not found', 'status' => false], 200);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message, 'status' => false], 200);
        }
    }


    public function detailsview(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $userRole = Auth::user()->role;
            $data = Task::with(['user', 'creator'])
                ->where('tasks.id', $request->id)
                ->first();
            $user_name = $data->user->name ?? 'N/A';
            $creator_name = $data->creator->name ?? 'N/A';
            $formatted_due_date = $data->due_date ? $data->due_date->format('Y-m-d') : 'N/A';
            $html = view('managedata.details', compact('data', 'user_name', 'creator_name', 'formatted_due_date'))->render();

            return response()->json(['html' => $html, 'status' => true]);
        } catch (\Exception $e) {
            return response()->json(['html' => "Something went wrong!", 'status' => false]);
        }
    }

    public function update(Request $request)
    {
        try {
            //validation using validate method
            $validatedData = $request->validate([
                'status' => 'required|in:inprogress,done,todo',
                'comments' => 'nullable|string',
                'task_date' => 'nullable|date',
                'completed_at' => 'nullable|date',
            ]);
            $task = Task::find($request->id_edit);
            $task->comments = $validatedData['comments'];
            $task->status = $validatedData['status'];
            $task->task_date = $validatedData['task_date'];
            $task->completed_at = $validatedData['completed_at'];
            $task->update();

            return back()->with('success', 'Task Updated Successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return response()->json(['html' => "Something went wrong!", 'status' => false]);
        }
    }
}
