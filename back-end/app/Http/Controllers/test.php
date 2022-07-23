<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class test extends Controller
{
    public function test(Request $request)
    {

        $leaders = RoleUser::with('troupe','role','user')->whereHas('role', function ($query) {
            $query->where('ename', 'like', '%Leader%');
        })->get();

        return response()->json($leaders, 200);
    }
}
