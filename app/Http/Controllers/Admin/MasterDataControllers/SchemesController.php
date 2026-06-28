<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Scheme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SchemesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view scheme', ['only' => ['index']]);
        $this->middleware('permission:create scheme', ['only' => ['store']]);
        $this->middleware('permission:update scheme', ['only' => ['update']]);
        $this->middleware('permission:delete scheme', ['only' => ['delete']]);
    }
    public function index()
    {
        $schemes = Scheme::orderby('scheme_code')->get();

        return view('admin.masterdata.scheme.index', compact('schemes'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'scheme_name' => 'required|string|regex:/^[a-zA-Z\s\(\)]+$/'

            ],
            [
                'scheme_name.required' => "Scheme name cannot be Empty.",
                'scheme_name.regex'=>"Scheme name can only contain letters, spaces and ()."
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
            Scheme::create([
                'scheme_name' => $request->scheme_name
            ]);
            Alert::toast("Scheme Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Scheme Created Successfully"
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
                'scheme_code' => 'required|exists:pgsql.Masterdata.schemes,scheme_code',
                'scheme_name' => 'required|regex:/^[a-zA-Z\s\(\)]+$/'
            ],
            [
                'scheme_name.required' => "Scheme name cannot be Empty.",
                'scheme_name.regex'=>"Scheme name can only contain letters, spaces and ()."
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
            Scheme::where('scheme_code', $request->scheme_code)->update([
                'scheme_name' => $request->scheme_name
            ]);
            Alert::toast("Scheme Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Scheme Updated Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }


    public function delete(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'scheme_id' => 'required|numeric|exists:pgsql.Masterdata.schemes,scheme_code'
            ],
            [
                'scheme_id.required' => "Scheme Code Required",
                'scheme_id.numeric' => "Scheme Code can only be Numeric",
                'scheme_id.exists' => "Scheme Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Scheme::where('scheme_code', $request->scheme_id)->delete();
                Alert::toast("Scheme Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
