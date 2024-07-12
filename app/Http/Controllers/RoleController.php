<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $roles = Role::where('name', 'LIKE', "%{$search}%")
                ->orWhere('id', $search)
                ->get();
        } else {
            $roles = Role::get();
        }

        $noRoles = $roles->isEmpty();

        return view('role-permission.role.index', [
            'roles' => $roles,
            'search' => $search,
            'noRoles' => $noRoles
        ]);
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'

            ]
        ]);

        Role::create([
            'name' => $request->name


        ]);
        return redirect('roles')->with('status', 'Role Create');
    }

    public function edit(Role $role)
    {


        return view('role-permission.role.edit', [
            'role' => $role


        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name,' . $role->id

            ]
        ]);

        $role->update([

            'name' => $request->name
        ]);

        return redirect('roles')->with('status', 'Role Updated');
    }

    public function destroy(request $request)
    {
        // dd(
        //     $request->all()
        // );


        $data = $request->id;
        DB::table('roles')->where('id',  $data)->delete();
        return response()->json(200);
        // $role = Role::find($roleId);
        // $role->delete();
        // return redirect('roles')->with('status', 'Role Deleted');
    }


    public function addPermissionToRole($roleId)
    {

        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('role-permission.role.add-permissions', [

            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }
    public function givePermissionToRole(Request $request, $roleId)
    {

        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status', 'Permission Added to Role');
    }
}
