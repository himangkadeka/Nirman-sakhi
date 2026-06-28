<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view skill', ['only' => ['index']]);
        $this->middleware('permission:create skill', ['only' => ['store']]);
        $this->middleware('permission:update skill', ['only' => ['update']]);
        $this->middleware('permission:delete skill', ['only' => ['delete']]);
    }

    public function index()
    {
        $skills = Skill::orderBy('skill_code')->get();
        return view('admin.masterdata.skill.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'skill_code' => 'required|numeric|unique:pgsql.Masterdata.skills,skill_code',
                'skill_name' => 'required|string|regex:/^[a-zA-Z0-9\s]+$/'
            ],
            [
                'skill_code.required' => "Skill Code Cannot be Empty!",
                'skill_code.numeric' => "Skill Code must be numeric",
                'skill_code.unique' => "Skill Code already exist.",
                'skill_name.required' => "Skill name cannot be Empty.",
                'skill_name.regex'=>"Skill name can only contain letters and spaces."
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
            Skill::create([
                'skill_code' => $request->skill_code,
                'skill_name' => $request->skill_name
            ]);
            Alert::toast("Skill Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Skill Created Successfully"
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
                'skill_code' => 'required|numeric|exists:pgsql.Masterdata.skills,skill_code',
                'skill_name' => ['required','regex:/^[a-zA-Z0-9\s]+$/']
            ],
            [
                'skill_code.required' => "Skill Code Cannot be Empty!",
                'skill_code.numeric' => "Skill Code must be numeric",
                'skill_name.required' => "Skill name cannot be Empty.",
                'skill_name.regex'=>"Skill name can only contain letters and spaces."
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
            Skill::where('skill_code', $request->skill_code)->update([
                'skill_name' => $request->skill_name
            ]);
            Alert::toast("Skill Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Skill Updated Successfully"
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
                'skill_id' => 'required|numeric|exists:pgsql.Masterdata.skills,skill_code'
            ],
            [
                'skill_id.required' => "Skill Code Required",
                'skill_id.numeric' => "Skill Code can only be Numeric",
                'skill_id.exists' => "Skill Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Skill::where('skill_code', $request->skill_id)->delete();
                Alert::toast("Skill Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
