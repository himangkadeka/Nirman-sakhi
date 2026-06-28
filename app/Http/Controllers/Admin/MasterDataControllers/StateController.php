<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class StateController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view state', ['only' => ['index']]);
        $this->middleware('permission:create state', ['only' => ['store']]);
        $this->middleware('permission:update state', ['only' => ['update','updateStatus']]);
    }


    public function index()
    {
        $states = State::all();
        return view('admin.masterdata.state.index', compact('states'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'statecode' => 'required|numeric|unique:pgsql.Masterdata.states,state_code',
                'statename' => 'required|regex:/^[\pL\s]+$/u|unique:pgsql.Masterdata.states,state_name'
            ],
            [
                'statecode.required' => 'State Code Cannot be Blank',
                'statecode.numeric' => 'State Code can only be Numeric',
                'statecode.unique' => "State Code Already Exist",
                'statename.required' => 'State Name Cannot be Blank',
                'statename.regex' => 'State Name Should conatin letters only',
                'statename.unique' => "State Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.states.index')->withInput()->withErrors($validator->errors());
        } else {
            try {
                State::create([
                    'state_code' => $request->statecode,
                    'state_name' => $request->statename,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                Alert::toast('State Added Sucessfully.', "success");
                return redirect()->route('admin.states.index');
            } catch (Exception $e) {
                Alert::toast("Something Went Wrong!", 'error');
                return redirect()->route('admin.states.index')->withInput();
            }
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
                'state_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'state_code.required' => 'State Code Cannot be Blank',
                'state_code.numeric' => 'State Code can only be Numeric',
                'state_name.required' => 'State Name Cannot be Blank',
                'state_name.regex' => 'State Name Should contain letters only',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
              // Combining error messages into a single string
        Alert::toast(implode("\n", $errors), 'error'); // Show all errors in the alert
        return response()->json([
                'status' => false,
                'results' => $validator->errors()
            ]);
        } else {
            try {
                State::where('state_code', $request->state_code)->update([
                    'state_code' => $request->state_code,
                    'state_name' => $request->state_name,
                    'status' => 1,
                    'updated_at' => now()
                ]);
                Alert::toast('State Updated Successfully.', "success");
                return response()->json([
                    'status' => true,
                    'results' => "State Updated Successfully."
                ]);
            } catch (Exception $e) {
                Alert::toast("Something Went Wrong!", 'error');
                return response()->json([
                    'status' => false,
                    'results' => $validator->errors()
                ]);
            }
        }
    }


    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.states.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $state = State::where('state_code', $request->state_code)->first();
            if (!$state) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'State Not Found');
                }
                return redirect()->route('admin.states.index')->withInput()->withErrors($validator->errors());
            }
            State::where('state_code', $request->state_code)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.states.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.states.index')->withInput();
        }
    }
}
