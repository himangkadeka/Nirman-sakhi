<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ResidenceTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view residence type', ['only' => ['index']]);
        $this->middleware('permission:create residence type', ['only' => ['store']]);
        $this->middleware('permission:update residence type', ['only' => ['update']]);
        $this->middleware('permission:delete residence type', ['only' => ['delete']]);
    }
    public function index()
    {

        $residence_types = Residence::orderBy('residence_code')->get();
        return view('admin.masterdata.residence-type.index', compact('residence_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'residence_type_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'residence_type_name.required' => "Residence Type Details Cannot be Empty",
                'residence_type_name.regex' => "Residence Type Details can only contain letters and spaces"
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
            Residence::create([
                'residence_name' => $request->residence_type_name
            ]);
            Alert::toast("Residence Type Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Residence Type Created Successfully!"
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
                'residence_type_code' => 'required|numeric|exists:pgsql.Masterdata.residences,residence_code',
                'residence_type_name' => 'required|regex:/^[a-zA-Z \s]+$/'
            ],
            [
                'residence_type_name.required' => "Residence Type Details Cannot be Empty",
                 'residence_type_name.regex' => "Residence Type Details can only contain letters and spaces"
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
            Residence::where('residence_code', $request->residence_type_code)->update([
                'residence_name' => $request->residence_type_name
            ]);
            Alert::toast("Residence Type Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Residence Type Updated Successfully!"
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
                'residence_type_id' => 'required|numeric|exists:pgsql.Masterdata.residences,residence_code'
            ],
            [
                'residence_type_id.required' => "Residence Type Code Required",
                'residence_type_id.numeric' => "Residence Type Code can only be Numeric",
                'residence_type_id.exists' => "Residence Type Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Residence::where('residence_code', $request->residence_type_id)->delete();
                Alert::toast("Residence Type Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
