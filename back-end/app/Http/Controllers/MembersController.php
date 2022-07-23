<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->user()->id;
        $troupe = RoleUser::with('troupe', 'role', 'user')->where('user_id', $id)
            ->whereHas('role', function ($query) {
                $query->where('ename', 'like', '%Unit Leader%');
            })->get()[0]->troupe->id;
        $leaders = RoleUser::with('troupe', 'role', 'user')->whereHas('role', function ($query) {
            $query->where('ename', 'like', '%Member%');
        })
            ->whereHas('troupe', function ($query) use ($troupe) {
                $query->where('id', $troupe);
            })
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

    public function accept($id, Request $request)
    {
        $member = RoleUser::find($id);
        $member->status = 1;
        $member->save();
        $year = date('Y');
        $subscription = Subscription::where('year', $year)->where('user_id', $member->user_id)->first();
        if (!$subscription) {
            Subscription::create([
                'user_id' => $member->user_id,
                'leader_id' => $request->user()->id,
                'year' => date('Y'),
            ]);
        }
        return response()->json($member, 200);
    }

    public function reject($id)
    {
        $member = RoleUser::find($id);
        $member->status = 0;
        $member->save();
        return response()->json($member, 200);
    }
}
