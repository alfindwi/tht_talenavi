<?php

namespace App\Http\Controllers;

use App\Models\todo;
use Illuminate\Http\Request;
use App\Exports\TodosExport;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class todoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'assignee' => 'nullable|string|max:255',
            'due_date' => 'nullable|date|after_or_equal:today',
            'time_tracked' => 'nullable|integer|min:0',
            'status' => 'nullable|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
        ], [
            'due_date.after_or_equal' => 'The due date must be today or a future date.',
            'status.in' => 'The selected status is invalid.',
            'priority.in' => 'The selected priority is invalid.',
            'time_tracked.integer' => 'The time tracked must be a number.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if (!isset($validated['status'])) {
            $validated['status'] = 'pending';
        }

        $todo = Todo::create($validated);

        return response()->json([
            'todo' => $todo
        ], 201);
    }

    public function exportExcel(Request $request)
    {
        $query = Todo::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('assignee')) {
            $assignees = array_map('trim', explode(',', $request->assignee));
            $query->whereIn('assignee', $assignees);
        }

        if ($request->filled('status')) {
            $statuses = array_map('trim', explode(',', $request->status));
            $query->whereIn('status', $statuses);
        }

        if ($request->filled('priority')) {
            $priorities = array_map('trim', explode(',', $request->priority));
            $query->whereIn('priority', $priorities);
        }

        if ($request->filled('due_date_start') && $request->filled('due_date_end')) {
            $query->whereBetween('due_date', [$request->due_date_start, $request->due_date_end]);
        }

        if ($request->filled('time_tracked_min') && $request->filled('time_tracked_max')) {
            $query->whereBetween('time_tracked', [$request->time_tracked_min, $request->time_tracked_max]);
        }

        $todos = $query->get();

        return Excel::download(new TodosExport($todos), 'todos.xlsx');
    }

    public function chartData(Request $request)
    {
        $type = $request->query('type');

        if ($type === "summary") {
            $allStatus = ['pending', 'open', 'in_progress', 'completed'];
            $status_sumarry = todo::selectRaw("status, COUNT(*) as count")
                ->groupBy('status')
                ->pluck("count", "status")
                ->ToArray();

            $statusSummary = [];
            foreach ($allStatus as $status) {
                $statusSummary[$status] = $status_sumarry[$status] ?? 0;
            }

            return response()->json([
                'status_summary' => $statusSummary
            ]);
        }

        if ($type === "priority") {
            $allPriority = ['low', 'medium', 'high'];
            $priority_sumarry = todo::selectRaw("priority, COUNT(*) as count")
                ->groupBy('priority')
                ->pluck("count", "priority")
                ->ToArray();

            $prioritySummary = [];
            foreach ($allPriority as $priority) {
                $prioritySummary[$priority] = $priority_sumarry[$priority] ?? 0;
            }


            return response()->json([
                'priority_summary' => $prioritySummary
            ]);
        }
        if ($type === "assignee") {
            $allAssignee = todo::distinct('assignee')->pluck('assignee')->toArray();

            $assignee_sumarry = [];

            foreach ($allAssignee as $assignee) {
                $totalTodos = todo::where('assignee', $assignee)->count();

                $totalPending = todo::where('assignee', $assignee)
                    ->where('status', 'pending')
                    ->count();

                $totalTimeTrackedCompleted = todo::where('assignee', $assignee)
                    ->where('status', 'completed')
                    ->sum('time_tracked');

                $assignee_sumarry[$assignee] = [
                    'total_todos' => $totalTodos,
                    'total_pending' => $totalPending,
                    'total_time_tracked_completed' => $totalTimeTrackedCompleted
                ];
            }

            return response()->json([
                'assignee_summary' => $assignee_sumarry
            ]);
        }

        return response()->json(['error' => 'Invalid type'], 400);
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
