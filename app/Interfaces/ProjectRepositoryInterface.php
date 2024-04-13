<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProjectRepositoryInterface
{
    public function index();

    public function store(Request $request);
}
