<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        try {
            Task::where('status', '!=', 'done')
                ->where('due_date', '<', now())
                ->update(['status' => 'due']);

            $user = Auth::user()->role;
            $SelectedCategory = $request->input('category', null);

            if ($user == 'Admin') {
                $todoCount = Task::where('status', 'todo')
                    ->count();
                $inprogressCount = Task::where('status', 'inprogress')
                    ->count();
                $doneCount = Task::where('status', 'done')
                    ->count();
                $overdueCount = Task::where('status', 'due')
                    ->count();
            } else {
                $user = Auth::user()->id;
                $todoCount = Task::where('status', 'todo')
                    ->where('user_id', $user)
                    ->count();
                $inprogressCount = Task::where('status', 'inprogress')
                    ->where('user_id', $user)
                    ->count();
                $doneCount = Task::where('status', 'done')
                    ->where('user_id', $user)
                    ->count();
                $overdueCount = Task::where('status', 'due')
                    ->where('user_id', $user)
                    ->count();
            }
            return view('dashboard', compact('todoCount', 'inprogressCount', 'doneCount', 'overdueCount'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function graph(Request $request)
    {
        try {
            // Define the date range, default to current month
            $startDate = $request->input('start_date', now()->startOfMonth());
            $endDate = $request->input('end_date', now()->endOfMonth());

            // Fetch data grouped by day of the week with hours difference
            $tasks = Task::selectRaw("DAYOFWEEK(task_date) as day, SUM(TIMESTAMPDIFF(HOUR, task_date, completed_at)) as total_hours")
                ->whereBetween('task_date', [$startDate, $endDate])
                ->groupBy('day')
                ->orderBy('day')
                ->get();
            dd($tasks);

            // Prepare data for the chart
            $chartData = $tasks->map(function ($task) {
                return [
                    'day' => $task->day, // Day as number (1 = Sunday, 7 = Saturday)
                    'total_hours' => $task->total_hours
                ];
            });

            return view('chart.graph', compact('chartData', 'startDate', 'endDate'));
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }
}
