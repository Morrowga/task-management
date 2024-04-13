<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\AjaxResponse;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{

    //ApiResponse to use json responses

    //fetching project data
    public function index()
    {
        try {
            $projects = Project::with('tasks')->orderBy('created_at', 'DESC')->get();
            //fetching tasks data
            return AjaxResponse::success($projects);
        } catch (\Exception $e) {
            return AjaxResponse::error($e);
        }
    }

    //store project data
    public function store(Request $request)
    {
        //database transition begin
        DB::beginTransaction();
        try {
            $project = Project::create($request->all());

            //commit data changes
            DB::commit();

            return AjaxResponse::success($project);

        } catch (\Exception $error) {
            //rollback data
            DB::rollBack();

            return AjaxResponse::error($error);
        }
    }
}
