<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['store']]);
        $this->middleware('permission:update permission', ['only' => ['update']]);
        $this->middleware('permission:delete permission', ['only' => ['delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $permissions = Permission::get();
    // return $permissions;
    return view('admin.user-management.permission.index',compact('permissions'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'permission_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
            [
                'permission_name.required' => "Permission Name Cannot be Empty!"
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
            Permission::create([
                'name' => $request->permission_name
            ]);
            Alert::toast("Permission Added Successfully", 'success');
            return response()->json([
                'status' => true,
                'results' => "Permission Added Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
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
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric|exists:pgsql.User.permissions,id',
                'permission_name' => 'required|string|regex:/^[a-zA-Z \s\(\)]+$/'
            ],
            [
                'permission_name.required' => "Role Name Cannot be Empty!"
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
            Permission::where('id', $request->id)->update([
                'name' => $request->permission_name
            ]);
            Alert::toast("Permission Updated Successfully", 'success');
            return response()->json([
                'status' => true,
                'results' => "Permission Updated Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'permission_id' => 'required|numeric|exists:pgsql.User.permissions,id'
            ],
            [
                'permission_id.required' => "Permission Id Required",
                'permission_id.numeric' => "Permission Id can only be Numeric",
                'permission_id.exists' => "Permission Id Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Permission::where('id', $request->permission_id)->delete();
                Alert::toast("Permission Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
