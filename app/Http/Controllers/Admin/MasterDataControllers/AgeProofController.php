<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\AgeProof;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AgeProofController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view age proof', ['only' => ['index']]);
        $this->middleware('permission:create age proof', ['only' => ['store']]);
        $this->middleware('permission:update age proof', ['only' => ['update']]);
        $this->middleware('permission:delete age proof', ['only' => ['delete']]);
    }

    public function index()
    {

        $age_proofs = AgeProof::orderBy('age_proof_code')->get();

        return view('admin.masterdata.age-proof.index', compact('age_proofs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'age_proof_name' => 'required|regex:/^[a-zA-Z\s\(\)]+$/'
            ],
            [
                'age_proof_name.required' => "Age Proof Name cannot be Empty!",
                'age_proof_name.regex' => 'Age Proof can only contain letters and spaces.'
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
            AgeProof::create([
                'age_proof_name' => $request->age_proof_name
            ]);
            Alert::toast("Age Proof Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Age Proof Created Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
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
                'age_proof_code' => 'required',
                'age_proof_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'age_proof_name.required' => "Age Proof Name cannot be Empty!",
                'age_proof_name.regex' => "Age Proof can only contain letters and spaces."
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
            AgeProof::where('age_proof_code',$request->age_proof_code)->update([
                'age_proof_name' => $request->age_proof_name
            ]);
            Alert::toast("Age Proof Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Age Proof Updated Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong.", 'error');
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
                'age_proof_id' => 'required|numeric|exists:pgsql.Masterdata.age_proofs,age_proof_code'
            ],
            [
                'age_proof_id.required' => "Age Proof Code Required",
                'age_proof_id.numeric' => "Age Proof Code can only be Numeric",
                'age_proof_id.exists' => "Age Proof Code Invalid"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                AgeProof::where('age_proof_code', $request->age_proof_id)->delete();
                Alert::toast("Age Proof Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
