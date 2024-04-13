<?php

namespace App\Http\Controllers\TaskManagement\Ajax;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Commands\Projects\StoreCommand;
use App\Http\Requests\ProjectCreateRequest;
use App\Interfaces\ProjectRepositoryInterface;

class ProjectController extends Controller
{
    protected $repository;

    //initiate the repository pattern in controller on construct
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->projectRepository->index();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectCreateRequest $request)
    {

        return $this->projectRepository->store($request);

    }
}
