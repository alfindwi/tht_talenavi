<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;

    protected $table = 'todoList';

    protected $fillable = [
        'title',
        'assignee',
        'due_date',
        'time_tracked',
        'status',
        'priority'
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
    ];
}
