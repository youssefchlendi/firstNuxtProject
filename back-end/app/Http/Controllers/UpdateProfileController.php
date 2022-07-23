<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateProfileController extends Controller
{
    public function updateImage(Request $request)
    {
        $user = $request->user();
        $user->image = $request->image;
        $user->save();
        return response()->json([
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birth_date = $request->birth_date;
        $user->sexe = $request->sexe;
        $user->phone_number = $request->phone_number;
        $user->save();
        return response()->json([
            'user' => $user
        ]);
    }
}
