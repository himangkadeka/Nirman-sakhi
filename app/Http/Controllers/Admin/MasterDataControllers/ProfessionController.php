<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProfessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view profession', ['only' => ['index']]);
        $this->middleware('permission:create profession', ['only' => ['store']]);
        $this->middleware('permission:update profession', ['only' => ['update']]);
        $this->middleware('permission:delete profession', ['only' => ['delete']]);
    }

    public function index()
    {
        $professions = Profession::orderBy('profession_code')->get();
        return view('admin.masterdata.profession.index', compact('professions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            [
                'profession_code' => 'required|numeric|uniques:pgsql.Masterdata.professions,profession_code',
                'profession_name' => ['required', 'regex:/^[a-zA-Z0-9\s]+$/']
            ],
            [
                'profession_code.required' => "Profession Code cannot be Empty!",
                'profession_code.numeric' => "Profession Code must be a number.",
                'profession_code.unique' => "Profession Code must be unique.",
                'profession_name.required' => "Profession Name cannot be Empty!",
                'profession_name.regex' => "Profession name can only contain letters and spaces."
            ]
        );

        if($validator->fails()){
            Alert::toast($validator->errors()->first(),'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try{
            Profession::create([
                'profession_code' => $request->profession_code,
                'profession_name' => $request->profession_name
            ]);
            Alert::toast("Profession Created Successfully!",'success');
            return response()->json([
                'status' => false,
                'results' => "Profession Created Successfully!"
            ]);
        }catch(Exception $e){
            Alert::toast("Something went Wrong!",'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            [
                'profession_code' => 'required|numeric|uniques:pgsql.Masterdata.professions,profession_code,'.$request->profession_code,
                'profession_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'profession_code.required' => "Profession Code cannot be Empty!",
                'profession_code.numeric' => "Profession Code must be a number.",
                'profession_code.unique' => "Profession Code must be unique.",
                'profession_name.required' => "Profession Name cannot be Empty!",
                'profession_name.regex' => "Profession name can only contain letters and spaces."
            ]
        );

        if($validator->fails()){
            Alert::toast($validator->errors()->first(),'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        }

        try{
            Profession::where('profession_code',$request->profession_code)->update([
                'profession_name' => $request->profession_name
            ]);
            Alert::toast("Profession Updated Successfully!",'success');
            return response()->json([
                'status' => false,
                'results' => "Profession Updated Successfully!"
            ]);
        }catch(Exception $e){
            Alert::toast("Something went Wrong!",'error');
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
                'profession_id' => 'required|numeric|exists:pgsql.Masterdata.professions,profession_code'
            ],
            [
                'profession_id.required' => "Profession Code Required",
                'profession_id.numeric' => "Profession Code can only be Numeric",
                'profession_id.exists' => "Profession Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Profession::where('profession_code', $request->profession_id)->delete();
                Alert::toast("Profession Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
