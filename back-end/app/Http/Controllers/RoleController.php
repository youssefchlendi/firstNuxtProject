<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::where("name","<>","superAdmin")->get();
        return response()->json($roles);
    }
}
