<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::withCount('permissions')->get();
        // dd($roles->toArray());
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // dd($request->toArray());
        $request->validate(
            [
                'role_name' => 'required|string|min:3',
            ],
            [
                'role_name.required' => 'من فضلك قم بادخال المسمى الوظيفي الجديد ',
                'role_name.string' => ' يجب ان تكون  حروف',
            ]
        );

        $role = new Role();
        $role->name =  $request->role_name;
        $role->guard_name =  'web';
        $isSaved =   $role->save();
        // dd($isSaved);
        session()->flash('message', 'تمت الأضافة بنجاح');

        return  redirect()->route('roles.index');



        // return redirect()->route('roles.index')->with('isSaved', $isSaved);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        // $role =  Role::findById($id)->delete();
        // return redirect()->back();
        $roleDestroy =  Role::destroy($id);
        if ($roleDestroy) {
            return response()->json(['icon' => 'success', 'title' => 'تم الحذف بنجاح'], 200);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'فشلت عملية الحذف !!'], 400);
        }
    }
}
