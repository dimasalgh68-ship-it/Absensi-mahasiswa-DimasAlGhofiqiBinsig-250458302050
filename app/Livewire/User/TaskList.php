<?php

namespace App\Livewire\User;

use App\Models\Task;
use App\Models\TaskAssignment;
use Livewire\Component;

class TaskList extends Component
{
    public $tasks;

    public function mount()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        $userId = auth()->id();
        $this->tasks = Task::where(function ($query) {
            $query->where('assigned_to', 'all_users')
                  ->orWhereHas('assignments', function ($q) {
                      $q->where('user_id', auth()->id());
                  });
        })->with(['assignments', 'submissions' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->get();
    }

    public function render()
    {
        return view('livewire.user.task-list');
    }
}
