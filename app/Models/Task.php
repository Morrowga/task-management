<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['name', 'priority'];

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($task) {
            $maxPriority = self::max('priority');

            $task->priority = $maxPriority ? $maxPriority + 1 : 1;
        });
    }
}
