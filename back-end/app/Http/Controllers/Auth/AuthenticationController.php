<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Responsability;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        if (!$this->getRoles(Auth::user()->id)['status']) {
            return response()->json([
                'status' => false,
                'error' => 'notAccepted',
                'message' => 'لم يتم قبولك في المنظمة بعد'
            ], 401);
        }
        return response()->json([
            'user'      => $user,
            'success'   => true,
            'responsability' => RoleUser::where('user_id', Auth::user()->id)->whereHas('role', function ($query) {
                $query->where('ename', 'like', '%Unit Assigned Leader%');
            })->with('responsability')->first()?->responsability[0]->ename,
            'status'    => $this->getRoles(Auth::user()->id)['status'],
            'roles'     => $this->getRoles(Auth::user()->id)['roles'],
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->sendEmailVerificationNotification();
        $role = Role::find($request->role);
        if ($request->troupe) {
            if ($request->responsability) {
                $user->roless()->attach($role, ['troupe_id' => $request->troupe, 'responsability_id' => $request->responsability]);
            } else {
                $user->roless()->attach($role, ['troupe_id' => $request->troupe]);
            }
        } else {
            $user->roless()->attach($role);
        }

        return response()->json([
            'success'   => true,
            'message'   => 'User created',
            'data'      => $user
        ]);
    }

    public function login(LoginRequest $request)
    {
        $input = $request->all();
        if (!Auth::attempt($input)) {
            return response()->json([
                'success'   => false,
                'message'   => 'المعلومات المدخلة غير صحيحة',
                'data'      => []
            ], 401);
        }
        $user = Auth::user();
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'success'   => false,
                'message'   => 'حسابك غير مفعل, يرجى التحقق من بريدك الإلكتروني',
                'data'      => []
            ], 401);
        }
        return response()->json([
            'success'   => true,
            'token'     => Auth::user()->createToken('token')->plainTextToken,
            'user'      => Auth::user(),
            'responsability' => RoleUser::where('user_id', Auth::user()->id)->whereHas('role', function ($query) {
                $query->where('ename', 'like', '%Unit Assigned Leader%');
            })->with('responsability')->first()?->responsability[0]->ename,
            'status'    => $this->getRoles(Auth::user()->id)['status'],
            'roles'     => $this->getRoles(Auth::user()->id)['roles'],
        ], 200);
    }

    public function unique($field)
    {
        $user = User::where('email', $field)->first();
        $user1 = User::where('cin', $field)->first();
        if ($user || $user1) {
            return response()->json([
                'success'   => false,
                'message'   => 'User already exists',
                'data'      => []
            ], 201);
        } else {
            return response()->json([
                'success'   => true,
                'message'   => 'User not exists',
                'data'      => []
            ]);
        }
    }
    public function getRoles($id)
    {
        $roles = RoleUser::with('role', 'troupe')->where('user_id', $id)->get();
        $roles_array = [];
        $status = false;
        foreach ($roles as $role) {
            $status = $status || $role->status;
            $roles_array[] = ['role' => $role->role->ename, 'troupe' => $role->troupe?->name, 'status' => $role->status];
        }
        return ['roles' => $roles_array, 'status' => $status];
    }
}
