<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:update permission', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $permissions = Permission::where('name', 'LIKE', "%{$search}%")
                ->orWhere('id', $search)
                ->get();
        } else {
            $permissions = Permission::get();
        }

        $noPermissions = $permissions->isEmpty();

        return view('role-permission.permission.index', [
            'permissions' => $permissions,
            'search' => $search,
            'noPermissions' => $noPermissions
        ]);
    }


    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'

            ]
        ]);

        Permission::create([
            'name' => $request->name


        ]);
        return redirect('permissions')->with('status', 'Permission Create');
    }

    public function edit(Permission $permission)
    {

        return view('role-permission.permission.edit', [
            'permission' => $permission


        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,' . $permission->id

            ]
        ]);

        $permission->update([

            'name' => $request->name
        ]);

        return redirect('permissions')->with('status', 'Permission Updated');
    }

    public function destroy(Request $request)
    {
        // dd($request->id);
        $data = $request->id;
        DB::table('permissions')->where('id',  $data)->delete();
        return response()->json(200);
        // $permission = Permission::find($permissionId);
        // $permission->delete();
        // return redirect('permissions')->with('status', 'Permission Deleted');
    }
}
