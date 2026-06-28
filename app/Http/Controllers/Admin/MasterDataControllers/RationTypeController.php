<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\RationType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view ration type', ['only' => ['index']]);
        $this->middleware('permission:create ration type', ['only' => ['store']]);
        $this->middleware('permission:update ration type', ['only' => ['update']]);
        $this->middleware('permission:delete ration type', ['only' => ['delete']]);
    }

    public function index()
    {
        $rationTypes = RationType::orderBy('ration_code')->get();
        return view('admin.masterdata.ration-type.index', compact('rationTypes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ration_type' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'ration_type.required' => "Ration Type Details Cannot be Empty",
                'ration_type.regex'=>"Ration Type Details can only contain letters and spaces."
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
            RationType::create([
                'name' => $request->ration_type
            ]);
            Alert::toast("Ration Type Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Ration Type Created Successfully!"
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
                'id' => 'required|numeric|exists:pgsql.Masterdata.ration_types,ration_code',
                'ration_type' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/'
            ],
            [
                'ration_type.required' => "Ration Type Details Cannot be Empty",
                'ration_type.regex'=>"Ration Type Details can only contain letters and spaces."
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
            RationType::where('ration_code',$request->id)->update([
                'name' => $request->ration_type
            ]);
            Alert::toast("Ration Type Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Ration Type Updated Successfully!"
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
                'ration_type_id' => 'required|numeric|exists:pgsql.Masterdata.ration_types,ration_code'
            ],
            [
                'ration_type_id.required' => "Ration Type Id Required",
                'ration_type_id.numeric' => "Ration Type Id can only be Numeric",
                'ration_type_id.exists' => "Ration Type Id Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                RationType::where('ration_code', $request->ration_type_id)->delete();
                Alert::toast("Ration Type Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
