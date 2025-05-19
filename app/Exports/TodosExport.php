<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TodosExport implements FromView
{
    protected $todos;

    public function __construct($todos)
    {
        $this->todos = $todos;
    }

    public function view(): View
    {
        $totalTasks = $this->todos->count();
        $totalTime = $this->todos->sum('time_tracked');

        return view('exports.todos', [
            'todos' => $this->todos,
            'totalTasks' => $totalTasks,
            'totalTime' => $totalTime,
        ]);
    }
}

