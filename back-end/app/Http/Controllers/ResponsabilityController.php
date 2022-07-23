<?php

namespace App\Http\Controllers;

use App\Models\Responsability;
use Illuminate\Http\Request;

class ResponsabilityController extends Controller
{
    public function index(){
        $responsabilities = Responsability::all();
        return response()->json($responsabilities, 200);
    }
}
