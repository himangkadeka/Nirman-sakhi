<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\TypeOfWork;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class WorkTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view work type', ['only' => ['index']]);
        $this->middleware('permission:create work type', ['only' => ['store']]);
        $this->middleware('permission:update work type', ['only' => ['update']]);
        $this->middleware('permission:delete work type', ['only' => ['delete']]);
    }

    public function index(){

        $work_types = TypeOfWork::orderBy('work_type_code')->get();
        return view('admin.masterdata.work-type.index',compact('work_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'work_type_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'work_type_name.required' => "Work Type Details Cannot be Empty",
                'work_type_name.regex' => "Work Type Details can only contain letters and spaces"
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
            TypeOfWork::create([
                'work_type_name' => $request->work_type_name
            ]);
            Alert::toast("Work Type Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Work Type Created Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
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
                'work_type_code' => 'required|numeric|exists:pgsql.Masterdata.type_of_works,work_type_code',
                'work_type_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'work_type_name.required' => "Designation Details Cannot be Empty",
                 'work_type_name.regex' => "Work Type Details can only contain letters and spaces"
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
            TypeOfWork::where('work_type_code',$request->work_type_code)->update([
                'work_type_name' => $request->work_type_name
            ]);
            Alert::toast("Work Type Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Work Type Updated Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
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
                'work_type_id' => 'required|numeric|exists:pgsql.Masterdata.type_of_works,work_type_code'
            ],
            [
                'work_type_id.required' => "Work Type Code Required",
                'work_type_id.numeric' => "Work Type Code can only be Numeric",
                'work_type_id.exists' => "Work Type Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                TypeOfWork::where('work_type_code', $request->work_type_id)->delete();
                Alert::toast("Work Type Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
