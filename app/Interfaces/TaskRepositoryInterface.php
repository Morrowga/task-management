<?php

namespace App\Interfaces;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function index(Project $project);

    public function store(Project $project, Request $request);

    public function update(Task $task, Request $request);

    public function destroy(Task $task);

    public function updateOrder(Request $request);
}
