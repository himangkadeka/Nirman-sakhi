<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\House;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class HouseTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view housetype', ['only' => ['index']]);
        $this->middleware('permission:create housetype', ['only' => ['store']]);
        $this->middleware('permission:update housetype', ['only' => ['update']]);
        $this->middleware('permission:delete housetype', ['only' => ['delete']]);
    }

    public function index()
    {
        $house_types = House::orderBy('house_code')->get();
        return view('admin.masterdata.house-type.index', compact('house_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'house_type_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'house_type_name.required' => "House Type name cannot be Empty.",
                'house_type_name.regex' => "House Type name can only contain letters and spaces"
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
            House::create([
                'house_type' => $request->house_type_name
            ]);
            Alert::toast("House Type Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "House Type Created Successfully"
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
                'house_type_code' => 'required|numeric|exists:pgsql.Masterdata.houses,house_code',
                'house_type_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'house_type_code.required' => "House Type Code Cannot be Empty!",
                'house_type_code.numeric' => "House Type Code must be numeric",
                'house_type_name.required' => "House Type name cannot be Empty.",
                'house_type_name.regex' => "House Type name can only contain letters and spaces"
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
            House::where('house_code', $request->house_type_code)->update([
                'house_type' => $request->house_type_name
            ]);
            Alert::toast("House Type Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "House Type Updated Successfully"
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
                'house_type_id' => 'required|numeric|exists:pgsql.Masterdata.houses,house_code'
            ],
            [
                'house_type_id.required' => "House Type Code Required",
                'house_type_id.numeric' => "House Type Code can only be Numeric",
                'house_type_id.exists' => "House Type Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                House::where('house_code', $request->house_type_id)->delete();
                Alert::toast("House Type Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
