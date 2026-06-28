<?php

namespace App\Http\Controllers\Admin\Office;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Office;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view office', ['only' => ['index']]);
        $this->middleware('permission:create office', ['only' => ['store']]);
        $this->middleware('permission:update office', ['only' => ['update']]);
        $this->middleware('permission:delete office', ['only' => ['delete']]);
    }

    public function index()
    {
        $offices = Office::orderBy('office_id')->get();
        $districts = District::where('status', 1)->where('state_code', 18)->orderBy('district_name')->get();
        return view('admin.office-management.offices.index', compact('offices', 'districts'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts,district_code',
                'office_name' => 'required|regex:/^[a-zA-Z \s\(\)]+$/',
                'egrass_office_name' => 'required|string'
            ],
            [
                'district_code.required' => "District Name is not Empty!",
                'district_code.numeric' => "Only numeric data allowed",
                'office_name.required' => "Office Name Cannot be Empty!",
                'egrass_office_name.required' => "eGrass Office Code Cannot be Empty!",
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }
        try {
            Office::create([
                'district_code' => $request->district_code,
                'office_name' => $request->office_name,
                'egrass_office_code' => $request->egrass_office_name

            ]);
            Alert::toast("Office Added Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Office Added Successfully!"
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
                'office_id' => 'required|numeric|exists:pgsql.Masterdata.offices,office_id',
                'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts,district_code',
                'office_name' => 'required|regex:/^[a-zA-Z \s\(\),]+$/'
            ],
            [
                'district_code.required' => "District Name is not Empty!",
                'district_code.numeric' => "Only numeric data allowed",
                'office_name.required' => "Office Name Cannot be Empty!"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                'status' => false,
                'results' => $validator->errors()->first()
            ]);
        }
        try {
            Office::where('office_id', $request->office_id)->update([
                'district_code' => $request->district_code,
                'office_name' => $request->office_name
            ]);
            Alert::toast("Office Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Office Updated Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.Masterdata.offices,office_id',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.offices.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $office = Office::where('office_id', $request->id)->first();
            if (!$office) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'Office Not Found');
                }
                return redirect()->route('admin.offices.index')->withInput()->withErrors($validator->errors());
            }
            Office::where('office_id', $request->id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.offices.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.offices.index')->withInput();
        }
    }



    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'office_code' => 'required|numeric|exists:pgsql.Masterdata.offices,office_id'
            ],
            [
                'office_code.required' => "Office Code Required",
                'office_code.numeric' => "Office Code can only be Numeric",
                'office_code.exists' => "Office Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Office::where('office_id', $request->office_code)->delete();
                Alert::toast("Office Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
