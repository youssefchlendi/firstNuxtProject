<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index(Request $request)
    {
        $id = $request->user()->id;
        $troupe = RoleUser::with('troupe', 'role', 'user')->where('user_id',$id)
        ->whereHas('role', function ($query) {
            $query->where('ename', 'like', '%Unit Assigned Leader%');
        })->get()[0]->troupe->id;
        $leaders = RoleUser::with('troupe', 'role', 'user','subscription')->whereHas('role', function ($query) {
            $query->where('ename', 'like', '%Member%');
        })
            ->whereHas('troupe', function ($query)use($troupe) {
                $query->where('id', $troupe);
            })
            ->get();
        return response()->json($leaders, 200);
    }

    public function accept(Request $request)
    {
        $year = date('Y');
        $subscription = Subscription::where('year',$year)->where('user_id',$request->user_id)->first();
        if (!$subscription) {
            $subscription = Subscription::create([
                'user_id' => $request->user_id,
                'leader_id' => $request->user()->id,
                'year' => $year,
            ]);
        }
        $subscription->leader_id = $request->user()->id;
        $subscription->status = 1;
        $subscription->save();
        if ($subscription) {
            return response()->json($subscription, 200);
        }else{
            return response()->json(['error' => 'Error'], 500);
        }
    }

    public function reject(Request $request)
    {
        $year = date('Y');
        $subscription = Subscription::where('year',$year)->where('user_id',$request->user_id)->first();
        if ($subscription) {
            $subscription->leader_id = $request->user()->id;
            $subscription->status = 0;
            $subscription->save();
            return response()->json($subscription, 200);
        }else{
            return response()->json(['error' => 'Error'], 500);
        }
    }
}
