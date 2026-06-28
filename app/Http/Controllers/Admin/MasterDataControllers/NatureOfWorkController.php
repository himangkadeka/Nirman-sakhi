<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\NatureOfWork;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class NatureOfWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view nature of work', ['only' => ['index']]);
        $this->middleware('permission:create nature of work', ['only' => ['store']]);
        $this->middleware('permission:update nature of work', ['only' => ['update']]);
        $this->middleware('permission:delete nature of work', ['only' => ['delete']]);
    }

    public function index()
    {
        $nature_of_works = NatureOfWork::orderBy('nature_of_work_code')->get();
        return view('admin.masterdata.nature-of-work.index', compact('nature_of_works'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nature_of_work_name' => 'required|string|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'nature_of_work_name.required' => "Nature Of Work name cannot be Empty.",
                'nature_of_work_name.regex' => "Nature Of Work name can only contain letters and spaces"
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
            NatureOfWork::create([
                'nature_of_work' => $request->nature_of_work_name
            ]);
            Alert::toast("Nature Of Work Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Nature Of Work Created Successfully"
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
                'nature_of_work_code' => 'required|numeric|exists:pgsql.Masterdata.nature_of_works,nature_of_work_code',
                'nature_of_work_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'nature_of_work_code.required' => "Nature Of Work Code Cannot be Empty!",
                'nature_of_work_code.numeric' => "Nature Of Work Code must be numeric",
                'nature_of_work_name.required' => "Nature Of Work name cannot be Empty.",
                'nature_of_work_name.regex' => "Nature Of Work name can only contain letters and spaces"
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
            NatureOfWork::where('nature_of_work_code', $request->nature_of_work_code)->update([
                'nature_of_work' => $request->nature_of_work_name
            ]);
            Alert::toast("Nature Of Work Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Nature Of Work Updated Successfully"
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
                'nature_of_work_id' => 'required|numeric|exists:pgsql.Masterdata.nature_of_works,nature_of_work_code'
            ],
            [
                'nature_of_work_id.required' => "Nature Of Work Code Required",
                'nature_of_work_id.numeric' => "Nature Of Work Code can only be Numeric",
                'nature_of_work_id.exists' => "Nature Of Work Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                NatureOfWork::where('nature_of_work_code', $request->nature_of_work_id)->delete();
                Alert::toast("Nature Of Work Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
