<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view designation', ['only' => ['index']]);
        $this->middleware('permission:create designation', ['only' => ['store']]);
        $this->middleware('permission:update designation', ['only' => ['update']]);
        $this->middleware('permission:delete designation', ['only' => ['delete']]);
    }
    public function index()
    {

        $designations = Designation::orderBy('id')->get();
        return view('admin.masterdata.designation.index', compact('designations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'designation_name' => 'required|string|regex:/^[a-zA-Z\s\.]+$/'

            ],
            [
                'designation_name.required' => "Designation Details Cannot be Empty",
                'designation_name.regex' => "Designation Details can only contain letters,spaces and ."
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
            Designation::create([
                'designation' => $request->designation_name
            ]);
            Alert::toast("Designation Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Designation Created Successfully!"
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
                'designation_code' => 'required|numeric|exists:pgsql.Masterdata.designations,id',
                'designation_name' => 'required|regex:/^[a-zA-Z\s\.]+$/'
            ],
            [
                'designation_name.required' => "Designation Details Cannot be Empty",
                'designation_name.regex' => "Designation Details can only contain letters,spaces and ."
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
            Designation::where('id', $request->designation_code)->update([
                'designation' => $request->designation_name
            ]);
            Alert::toast("Designation Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Designation Updated Successfully!"
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
                'designation_id' => 'required|numeric|exists:pgsql.Masterdata.designations,id'
            ],
            [
                'designation_id.required' => "Designation Id Required",
                'designation_id.numeric' => "Designation Id can only be Numeric",
                'designation_id.exists' => "Designation Id Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Designation::where('id', $request->designation_id)->delete();
                Alert::toast("Designation Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
