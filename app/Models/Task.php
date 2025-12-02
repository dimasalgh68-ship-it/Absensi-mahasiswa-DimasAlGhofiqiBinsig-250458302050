<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'due_date',
        'created_by',
        'status',
        'image_path',
        'link',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function isOverdue(): bool
    {
        return now()->isAfter($this->due_date);
    }

    public function getAssignedUsers()
    {
        if ($this->assigned_to === 'all_users') {
            return User::where('group', 'user')->get();
        }

        return $this->assignments->map->user;
    }
}
