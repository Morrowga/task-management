<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\AjaxResponse;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    //ApiResponse to use json responses

    public function index(Project $project)
    {
        try {
            //fetching tasks data
            return AjaxResponse::success($project->tasks);
        } catch (Exception $e) {
            return AjaxResponse::error($e);
        }
    }

    public function store(Project $project, Request $request)
    {
        //database transition begin
        DB::beginTransaction();
        try {
            //create task data
            $task = Task::create($request->all());

            //project attach with tasks
            $project->tasks()->attach($task->id);

            //commit data changes
            DB::commit();

            return AjaxResponse::success($task);

        } catch (\Exception $error) {
            //rollback data
            DB::rollBack();

            return AjaxResponse::error($error);
        }
    }

    public function update(Task $task, Request $request)
    {
        //database transition begin
        DB::beginTransaction();
        try {
            //update task data
            $task->update($request->all());

            //commit data changes
            DB::commit();

            return AjaxResponse::success($task);

        } catch (\Exception $error) {
            //rollback data
            DB::rollBack();

            return AjaxResponse::error($error);
        }
    }

    public function destroy(Task $task)
    {
        //database transition begin
        DB::beginTransaction();
        try {
            //delete task data
            $task->delete();

            //commit data changes
            DB::commit();

            return AjaxResponse::success([]);

        } catch (\Exception $error) {
            //rollback data
            DB::rollBack();

            return AjaxResponse::error($error);
        }
    }


    public function updateOrder(Request $request)
    {
        //database transition begin
        DB::beginTransaction();
        try {
            //decode tasks data
            $tasks = json_decode($request->tasks, true);

            foreach($tasks as $key => $task){
                $taskEloquentData = Task::find($task['id']);
                if($taskEloquentData)
                {
                    //update priority field
                    $taskEloquentData->update(['priority' => $key + 1]);
                }
            }

            //commit data changes
            DB::commit();

            return AjaxResponse::success([]);

        } catch (\Exception $error) {
            //rollback data
            DB::rollBack();

            return AjaxResponse::error($error);
        }
    }
}
