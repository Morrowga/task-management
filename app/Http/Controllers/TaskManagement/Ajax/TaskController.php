<?php

namespace App\Http\Controllers\TaskManagement\Ajax;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Interfaces\TaskRepositoryInterface;

class TaskController extends Controller
{
    protected $repository;

    //initiate the repository pattern in controller on construct
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    //display data resource
    public function index(Project $project)
    {

       return $this->taskRepository->index($project);

    }

    //store a new task resource
    public function store(Project $project, TaskCreateRequest $request)
    {
        return $this->taskRepository->store($project, $request);

    }

    //update existing task resource
    public function update(Task $task, TaskUpdateRequest $request)
    {
        
        return $this->taskRepository->update($task, $request);

    }

    //destroy existing task resource
    public function destroy(Task $task)
    {

        return $this->taskRepository->destroy($task);

    }

    //update existing task orders
    public function updateOrder(UpdateOrderRequest $request)
    {

        return $this->taskRepository->updateOrder($request);

    }
}
