@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <div class="col-md-6">
            <button  data-bs-toggle="modal" data-bs-target="#createProjectModal" class="btn custom-btn a-no-decoration border-radius-20"><i class="fa-solid fa-plus mr-2"></i> New Project</button>
        </div> --}}
        <div class="d-flex justify-content-start">
            <div class="mt-1 mx-3">
                <h3>Task Managment</h3>
            </div>
            <button  data-bs-toggle="modal" data-bs-target="#createProjectModal" class="btn custom-btn a-no-decoration border-radius-20"><i class="fa-solid fa-plus mr-2"></i> New Project</button>
        </div>
        <div class="col-md-4 my-4">
            <div class="mt-4">
                <select class="form-select" id="project-dropdown" aria-label="Default select example">
                </select>
            </div>
        </div>
        <div class="task-section" hidden>
            <div class=" d-flex justify-content-end">
                <button class="btn custom-btn mx-3 border-radius-20" data-bs-toggle="modal" data-bs-target="#createTaskModal">Task <i class="fa-solid fa-plus mr-2"></i></button>
            </div>
            <span class="paragraph">
                Total Tasks
                <p class="number-text">
                    0
                </p>
            </span>
            <div class="my-2">
                <ul id="tasks-sortable" class="list-unstyled">

                </ul>
            </div>
        </div>
    </div>


    @include('partials.tasks.createModal')
    @include('partials.tasks.updateModal')
    @include('partials.projects.createModal')
@endsection

@push('scripts')
    <script src="../js/home.js"></script>
@endpush
