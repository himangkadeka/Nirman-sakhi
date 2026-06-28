<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\SubDistrict;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SubDistrictController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view subdistrict', ['only' => ['index']]);
        $this->middleware('permission:create subdistrict', ['only' => ['store']]);
        $this->middleware('permission:update subdistrict', ['only' => ['update']]);
        $this->middleware('permission:delete subdistrict', ['only' => ['delete']]);
    }
    public function index()
    {

        $subdistricts = SubDistrict::all();
        $states = State::where('status', 1)->orderBy('state_name')->get();
        return view('admin.masterdata.sub-district.index', compact('subdistricts', 'states'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states.state_code',
                'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts.district_code',
                'subdistrict_code' => 'required|numeric|unique:pgsql.Masterdata.sub_districts,subdistrict_code',
                'subdistrict_name' => 'required|regex:/^[\pL\s]+$/u|unique:pgsql.Masterdata.sub_districts,subdistrict_name'
            ],
            [
                'state_code.required' => 'State Name Cannot be Blank',
                'state_code.numeric' => 'State Name can only be Numeric',
                'district_code.required' => 'District Name Cannot be Blank',
                'district_code.numeric' => 'District Name can only be Numeric',
                'subdistrict_code.required' => 'Sub District Name Cannot be Blank',
                'subdistrict_code.numeric' => 'Sub District Code can only be Numeric',
                'subdistrict_code.unique' => "Sub District Code Already Exist",
                'subdistrict_name.required' => 'Sub District Name Cannot be Blank',
                'subdistrict_name.regex' => 'Sub District Name Should conatin letters only',
                'subdistrict_name.unique' => "Sub District Code Already Exist",
            ]
        );

        if ($validator->fails()) {

            Alert::toast($validator->errors()->first(), 'error');

            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        } else {
            try {
                SubDistrict::create([
                    'state_code' => $request->state_code,
                    'district_code' => $request->district_code,
                    'subdistrict_code' => $request->subdistrict_code,
                    'subdistrict_name' => $request->subdistrict_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Alert::toast('Sub District Added Sucessfully.', "success");
                return response()->json([
                    'status' => true,
                    'message' => "Sub District Added Sucessfully."
                ]);
            } catch (Exception $e) {
                Alert::toast('Something Went Wrong!', 'error');
                return response()->json([
                    'status' => false,
                    'message' => $e
                ]);
            }
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
                'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts,district_code',
                'subdistrict_code' => 'required|numeric|exists:pgsql.Masterdata.sub_districts,subdistrict_code',
                'subdistrict_name' => 'required|regex:/^[\pL\s]+$/u'
            ],
            [
                'state_code.required' => 'State Name Cannot be Blank',
                'state_code.numeric' => 'State Name can only be Numeric',
                'district_code.required' => 'District Name Cannot be Blank',
                'district_code.numeric' => 'District Name can only be Numeric',
                'subdistrict_code.required' => 'Sub District Name Cannot be Blank',
                'subdistrict_code.numeric' => 'Sub District Code can only be Numeric',
                'subdistrict_name.required' => 'Sub District Name Cannot be Blank',
                'subdistrict_name.regex' => 'Sub District Name Should conatin letters only',
                'subdistrict_name.unique' => "Sub District Name Already Exist",
            ]
        );

        if ($validator->fails()) {

            Alert::toast($validator->errors()->first(), 'error');

            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        } else {
            try {
                SubDistrict::where('subdistrict_code', $request->subdistrict_code)->update([
                    'state_code' => $request->state_code,
                    'district_code' => $request->district_code,
                    'subdistrict_code' => $request->subdistrict_code,
                    'subdistrict_name' => $request->subdistrict_name,
                ]);
                Alert::toast('Sub District Updated Sucessfully.', "success");
                return response()->json([
                    'status' => true,
                    'message' => "Sub District Updated Sucessfully."
                ]);
            } catch (Exception $e) {
                Alert::toast('Something Went Wrong!', 'error');
                return response()->json([
                    'status' => false,
                    'message' => $e
                ]);
            }
        }
    }


    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'sub_district_code' => 'required|numeric|exists:pgsql.Masterdata.sub_districts,subdistrict_code'
            ],
            [
                'sub_district_code.required' => "Sub District Code Required",
                'sub_district_code.numeric' => "Sub District Code can only be Numeric",
                'sub_district_code.exists' => "Sub District Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(),'error');
            return back();
        } else {
            try {
                SubDistrict::where('subdistrict_code', $request->sub_district_code)->delete();
                Alert::toast("Sub District Deleted Successfully",'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong",'error');
                return back();
            }
        }
    }
}
