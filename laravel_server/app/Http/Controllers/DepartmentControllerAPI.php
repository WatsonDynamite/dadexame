<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Department as DepartmentResource;
use App\Department;

class DepartmentControllerAPI extends Controller
{
    //
    public function index()
    {
        return DepartmentResource::collection(Department::all());
    }
}
