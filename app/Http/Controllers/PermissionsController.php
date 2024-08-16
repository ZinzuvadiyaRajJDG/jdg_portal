<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions= Permission::all();
        return view('permissions.index',['permissions'=>$permissions]);
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function show($id)
    {
        $permission = Permission::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('permissions.show',compact('permission','rolePermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'guard_name' => 'web',
        ]);
    
        return redirect('permissions')
                        ->with('success','Permissions created successfully');
    }

    public function edit($id)
    {
        $permission= Permission::FindOrfail($id);
        return view('permissions.edit',['permission'=>$permission]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        // Find the permission record to be updated
        $permission = Permission::findOrFail($id);

        // Update the permission record with the new data from the request
        $permission->name = $request->input('name');
        // Update other fields if needed

        // Save the updated permission record
        $permission->save();

        // Redirect back to the index page or show a success message
        return redirect('permissions/')->with('success', 'Permission updated successfully');
    }


    public function destroy($id)
    {
        $permission = Permission::where('id', $id)->where('guard_name', 'web')->first();
        if ($permission) {
            $permission->delete();
        }

        //  DB::table("permissions")->where('id',$id)->delete();
        return redirect('permissions')
                        ->with('success','Permission deleted successfully');
    }
}
