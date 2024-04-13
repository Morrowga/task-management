<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = ['name'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'project_task')->orderBy('priority', 'ASC');
    }

}
