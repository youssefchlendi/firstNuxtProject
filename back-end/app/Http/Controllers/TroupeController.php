<?php

namespace App\Http\Controllers;

use App\Models\Troupe;
use Illuminate\Http\Request;

class TroupeController extends Controller
{
    public function index()
    {
        $troups = Troupe::all();
        return response()->json($troups);
    }

    public function store(Request $request)
    {
        $troupe = Troupe::create([
            'name' => $request->name,
            'description' => $request->description,
            'gender' => $request->gender,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age
        ]);

        if ($troupe) {
            return response()->json("success", 200);
        } else {
            return response()->json("error", 400);
        }
    }

    public function update(Request $request, $id)
    {
        $troupe = Troupe::find($id);
        if ($troupe) {
            $troupe->name = $request->name;
            $troupe->description = $request->description;
            $troupe->gender = $request->gender;
            $troupe->max_age = $request->max_age;
            $troupe->min_age = $request->min_age;
            $troupe->save();
            return response()->json("success", 200);
        } else {
            return response()->json("error", 404);
        }
    }

    public function destroy($id)
    {
        $troupe = Troupe::find($id);
        if ($troupe) {
            $troupe->delete();
            return response()->json("success", 200);
        } else {
            return response()->json("error", 404);
        }
    }
}
