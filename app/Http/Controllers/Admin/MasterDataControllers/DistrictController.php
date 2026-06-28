<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DistrictController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view district', ['only' => ['index']]);
        $this->middleware('permission:create district', ['only' => ['store']]);
        $this->middleware('permission:update district', ['only' => ['update','updateStatus']]);
    }


    public function index()
    {
        $districts = District::orderBy('district_name')->get();
        $states = State::where('status',1)->orderBy('state_name')->get();
        return view('admin.masterdata.district.index', compact('districts','states'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
                'district_code' => 'required|numeric|unique:pgsql.Masterdata.districts,district_code',
                'district_name' => 'required|regex:/^[\pL\s]+$/u|unique:pgsql.Masterdata.districts,district_name'
            ],
            [
                'state_code.required' => 'State Name Cannot be Blank',
                'state_code.numeric' => 'State Name can only be Numeric',
                'state_code.unique' => "State Name Already Exist",
                'district_code.required' => 'District Name Cannot be Blank',
                'district_code.numeric' => 'District Name can only be Numeric',
                'district_code.unique' => "District Name Already Exist",
                'district_name.required' => 'District Name Cannot be Blank',
                'district_name.regex' => 'District Name Should conatin letters only',
                'district_name.unique' => "District Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.districts.index')->withInput()->withErrors($validator->errors());
        } else {
            try {
                District::create([
                    'state_code' => $request->state_code,
                    'district_code' => $request->district_code,
                    'district_name' => $request->district_name,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Alert::toast('District Added Sucessfully.', "success");
                return redirect()->route('admin.districts.index');
            } catch (Exception $e) {
                Alert::toast("Something Went Wrong!", 'error');
                return redirect()->route('admin.districts.index')->withInput();
            }
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
                'district_code' => 'required|numeric',
                'district_name' => 'required|string|regex:/^[\pL\s]+$/u'
            ],
            [
                'state_code.required' => 'State Name Cannot be Blank',
                'state_code.numeric' => 'State Name can only be Numeric',
                'district_code.required' => 'District Name Cannot be Blank',
                'district_code.numeric' => 'District Name can only be Numeric',
                'district_name.required' => 'District Name Cannot be Blank',
                'district_name.regex' => 'District Name Should conatin letters only',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json([
                'status' =>false,
                'results' => $validator->errors()->first()
            ]);
        } else {
            try {
                District::where('district_code', $request->district_code)->update([
                    'state_code' => $request->state_code,
                    'district_code' => $request->district_code,
                    'district_name' => $request->district_name,
                    'status' => 1,
                    'updated_at' => now()
                ]);
                Alert::toast('District Updated Successfully.', "success");
                return response()->json([
                    'status' => true,
                    'results' => 'District Updated Successfully.'
                ]);
            } catch (Exception $e) {
                Alert::toast("Something Went Wrong!", 'error');
                return response()->json([
                    'status' =>false,
                    'results' => $e
                ]);
            }
        }
    }


    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts,district_code',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.districts.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $state = District::where('district_code', $request->district_code)->first();
            if (!$state) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'District Not Found');
                }
                return redirect()->route('admin.districts.index')->withInput()->withErrors($validator->errors());
            }
            District::where('district_code', $request->district_code)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.districts.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.districts.index')->withInput();
        }
    }
}
