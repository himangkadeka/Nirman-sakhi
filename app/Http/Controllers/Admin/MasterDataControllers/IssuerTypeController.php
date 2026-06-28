<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\TypeOfIssuer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class IssuerTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view issuer type', ['only' => ['index']]);
        $this->middleware('permission:create issuer type', ['only' => ['store']]);
        $this->middleware('permission:update issuer type', ['only' => ['update']]);
        $this->middleware('permission:delete issuer type', ['only' => ['delete']]);
    }

    public function index()
    {

        $issuer_types = TypeOfIssuer::orderBy('issuer_code')->get();
        return view('admin.masterdata.issuer-type.index', compact('issuer_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'issuer_type_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'issuer_type_name.required' => "Issuer Type Details Cannot be Empty",
                'issuer_type_name.regex' => "Issuer Type Details can only contain letters and spaces"
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
            TypeOfIssuer::create([
                'issuer_name' => $request->issuer_type_name
            ]);
            Alert::toast("Issuer Type Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Issuer Type Created Successfully!"
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
                'issuer_type_code' => 'required|numeric|exists:pgsql.Masterdata.type_of_issuers,issuer_code',
              'issuer_type_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'issuer_type_name.required' => "Issuer Type Details Cannot be Empty",
                 'issuer_type_name.regex' => "Issuer Type Details can only contain letters and spaces"
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
            TypeOfIssuer::where('issuer_code', $request->issuer_type_code)->update([
                'issuer_name' => $request->issuer_type_name
            ]);
            Alert::toast("Issuer Type Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Issuer Type Updated Successfully!"
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
                'issuer_type_id' => 'required|numeric|exists:pgsql.Masterdata.type_of_issuers,issuer_code'
            ],
            [
                'issuer_type_id.required' => "Issuer Type Code Required",
                'issuer_type_id.numeric' => "Issuer Type Code can only be Numeric",
                'issuer_type_id.exists' => "Issuer Type Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                TypeOfIssuer::where('issuer_code', $request->issuer_type_id)->delete();
                Alert::toast("Issuer Type Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
