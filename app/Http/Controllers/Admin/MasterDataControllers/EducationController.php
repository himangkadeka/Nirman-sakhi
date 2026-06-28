<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use Exception;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class EducationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view education', ['only' => ['index']]);
        $this->middleware('permission:create education', ['only' => ['store']]);
        $this->middleware('permission:update education', ['only' => ['update']]);
        $this->middleware('permission:delete education', ['only' => ['delete']]);
    }
    public function index()
    {
        $educations = Education::orderBy('education_code')->get();
        return view('admin.masterdata.education.index', compact('educations'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'education_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/'
            ],
            [
                'education_name.required' => "Education name cannot be Empty.",
                'education_name.regex' => "Education name can only contain letters,numbers and spaces"
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
            Education::create([
                'education_name' => $request->education_name
            ]);
            Alert::toast("Education Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Education Created Successfully"
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
                'education_code' => 'required|numeric|exists:pgsql.Masterdata.educations,education_code',
                'education_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/'
            ],
            [
                'education_code.required' => "Education Code Cannot be Empty!",
                'education_code.numeric' => "Education Code must be numeric",
                'education_name.required' => "Education name cannot be Empty.",
                'education_name.regex' => "Education name can only contain letters,numbers and spaces"
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
            Education::where('education_code', $request->education_code)->update([
                'education_name' => $request->education_name
            ]);
            Alert::toast("Education Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Education Updated Successfully"
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
                'education_id' => 'required|numeric|exists:pgsql.Masterdata.educations,education_code'
            ],
            [
                'education_id.required' => "Education Code Required",
                'education_id.numeric' => "Education Code can only be Numeric",
                'education_id.exists' => "Education Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                education::where('education_code', $request->education_id)->delete();
                Alert::toast("Education Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
