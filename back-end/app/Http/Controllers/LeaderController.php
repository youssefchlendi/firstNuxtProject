<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaders = RoleUser::with('troupe', 'role', 'user', 'responsability')
            ->whereHas('role', function ($query) {
                $query->where('ename', 'like', '%Leader%');
            })
            ->orderBy('status', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->json($leaders, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accept($id)
    {
        $leader = RoleUser::with('troupe', 'role')
            ->with('role')->find($id);
        if ($leader->role->ename == 'Unit Assigned Leader') {
            $otherLeaders = RoleUser
                ::where('troupe_id', $leader->troupe_id)
                ->where('role_id', $leader->role_id)
                ->where('responsability_id', $leader->responsability_id)
                ->where('user_id', '!=', $leader->user_id)
                ->where('status', 1)

                ->get();
            if (count($otherLeaders) > 0) {
                return response()->json(['error' => 'يوجد ' . $leader->role->name . ' معين ل' . $leader->troupe->name . ' '.$leader->responsability[0]->name.'.'], 400);
            } else {
                $leader->status = 1;
            }
            $leader->save();
        } else {
            $otherLeaders = RoleUser
                ::where('troupe_id', $leader->troupe_id)
                ->where('role_id', $leader->role_id)
                ->where('user_id', '!=', $leader->user_id)
                ->where('status', 1)

                ->get();
            if (count($otherLeaders) > 0) {
                return response()->json(['error' => 'يوجد ' . $leader->role->name . ' معين ل' . $leader->troupe->name . '.'], 400);
            } else {
                $leader->status = 1;
            }
            $leader->save();
        }
        return response()->json($leader, 200);
    }

    public function reject($id)
    {
        $leader = RoleUser::find($id);
        $leader->status = 0;
        $leader->save();
        return response()->json($leader, 200);
    }
}
