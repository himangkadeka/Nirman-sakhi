<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['store','addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update']]);
        $this->middleware('permission:delete role', ['only' => ['delete']]);
    }


    public function index()
    {
        $roles = Role::get();
        return view('admin.user-management.roles.index', compact('roles'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
            [
                'role_name.required' => "Role Name Cannot be Empty!"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try {
            Role::create([
                'name' => $request->role_name
            ]);
            Alert::toast("Role Added Successfully", 'success');
            return response()->json([
                'status' => true,
                'results' => "Role Added Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:pgsql.User.roles,id',
                'role_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
            [
                'role_name.required' => "Role Name Cannot be Empty!"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try {
            Role::where('id', $request->id)->update([
                'name' => $request->role_name
            ]);
            Alert::toast("Role Updated Successfully", 'success');
            return response()->json([
                'status' => true,
                'results' => "Role Updated Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }


    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'role_id' => 'required|numeric|exists:pgsql.User.roles,id'
            ],
            [
                'role_id.required' => "Role Id Required",
                'role_id.numeric' => "Role Id can only be Numeric",
                'role_id.exists' => "Role Id Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Role::where('id', $request->role_id)->delete();
                Alert::toast("Role Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }


    public function addPermissionToRole($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::get();
        $rolePermissions = DB::table('User.role_has_permissions')->where('User.role_has_permissions.role_id', $role->id)
            ->pluck('User.role_has_permissions.permission_id', 'User.role_has_permissions.permission_id')
            ->all();
        return view('admin.user-management.roles.add-permission', compact('role', 'permissions', 'rolePermissions'));
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'permission' => 'required'
            ]
        );

        if ($validator->fails()) {
            Alert::error($validator->errors()->first());
            return back();
        }

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        Alert::toast("Permission Added to Role",'success');

        return redirect()->route('admin.roles.index');
    }
}
