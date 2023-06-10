<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    //


    public function index($user_id)
    {


        $roles = Role::all();
        $user =  User::with('roles')->where('id', $user_id)->first();
        // dd($user->toArray());
        return view('users.userRole')->with(['user' => $user,  'roles' => $roles]);
    }



    public function removeRole($roleId,  $userId)
    {
        $role = Role::findById($roleId);
        $user  =  User::find($userId);

        $status =  $user->removeRole($role->name);

        if ($status) {
            return response()->json(['icon' => 'success', 'title' => 'تم تحرير الموظف من الصلاحية'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية التحرير !!'], 400);
        }
    }


    public function addRole(Request $request, $userID)
    {

        $roles = $request['roles'];
        $user = User::find($userID);
        foreach ($roles as $role) {
            // dd($role);
            $status =  $user->assignRole($role);
        }
        session()->flash('status', $status);
        return redirect()->back();
    }
}