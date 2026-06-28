<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GenderController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view gender', ['only' => ['index']]);
        $this->middleware('permission:create gender', ['only' => ['store']]);
        $this->middleware('permission:update gender', ['only' => ['update']]);
        $this->middleware('permission:delete gender', ['only' => ['delete']]);
    }

    public function index()
    {
        $genders = Gender::orderBy('gender_code')->get();
        return view('admin.masterdata.gender.index', compact('genders'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'gender_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'gender_name.required' => "Gender name cannot be Empty.",
                'gender_name.regex' => "Gender name can only contain letters and spaces"
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
            Gender::create([
                'gender_name' => $request->gender_name
            ]);
            Alert::toast("Gender Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Gender Created Successfully"
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
                'gender_code' => 'required|numeric|exists:pgsql.Masterdata.genders,gender_code',
                'gender_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'gender_code.required' => "Gender Code Cannot be Empty!",
                'gender_code.numeric' => "Gender Code must be numeric",
                'gender_name.required' => "Gender name cannot be Empty.",
                'gender_name.regex' => "Gender name can only contain letters and spaces"
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
            Gender::where('gender_code', $request->gender_code)->update([
                'gender_name' => $request->gender_name
            ]);
            Alert::toast("Gender Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Gender Updated Successfully"
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
                'gender_id' => 'required|numeric|exists:pgsql.Masterdata.genders,gender_code'
            ],
            [
                'gender_id.required' => "Gender Code Required",
                'gender_id.numeric' => "Gender Code can only be Numeric",
                'gender_id.exists' => "Gender Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Gender::where('gender_code', $request->gender_id)->delete();
                Alert::toast("Gender Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
