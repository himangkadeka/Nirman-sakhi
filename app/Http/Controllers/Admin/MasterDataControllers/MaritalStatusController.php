<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\MaritalStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class MaritalStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view marital', ['only' => ['index']]);
        $this->middleware('permission:create marital', ['only' => ['store']]);
        $this->middleware('permission:update marital', ['only' => ['update']]);
        $this->middleware('permission:delete marital', ['only' => ['delete']]);
    }


    public function index()
    {
        $marital_statuses = MaritalStatus::orderBy('marital_code')->get();
        return view('admin.masterdata.marital-status.index', compact('marital_statuses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'marital_status_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'marital_status_name.required' => "Marital Status name cannot be Empty.",
                'marital_status_name.regex' => "Marital Status name can only contain letters and spaces."
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
            MaritalStatus::create([
                'marital_status' => $request->marital_status_name
            ]);
            Alert::toast("Marital Status Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Marital Status Created Successfully"
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
                'marital_status_code' => 'required|numeric|exists:pgsql.Masterdata.marital_statuses,marital_code',
                'marital_status_name' => ['required', 'string', 'regex:/^[a-zA-Z\s]+$/']
            ],
            [
                'marital_status_code.required' => "Marital Status Code Cannot be Empty!",
                'marital_status_code.numeric' => "Marital Status Code must be numeric",
                'marital_status_name.required' => "Marital Status name cannot be Empty.",
                'marital_status_name.regex' => "Marital Status name can only contain letters and spaces."
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
            MaritalStatus::where('marital_code', $request->marital_status_code)->update([
                'marital_status' => $request->marital_status_name
            ]);
            Alert::toast("Marital Status Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Marital Status Updated Successfully"
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
                'marital_status_id' => 'required|numeric|exists:pgsql.Masterdata.marital_statuses,marital_code'
            ],
            [
                'marital_status_id.required' => "Marital Status Code Required",
                'marital_status_id.numeric' => "Marital Status Code can only be Numeric",
                'marital_status_id.exists' => "Marital Status Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                MaritalStatus::where('marital_code', $request->marital_status_id)->delete();
                Alert::toast("Marital Status Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
