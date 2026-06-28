<?php

namespace App\Http\Controllers\Admin\MasterdataControllers;

use App\Http\Controllers\Controller;
use App\Models\Amount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AmountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index','store','update','delete']]);
        $this->middleware('permission:view amount', ['only' => ['index']]);
        $this->middleware('permission:create amount', ['only' => ['store']]);
        $this->middleware('permission:update amount', ['only' => ['update']]);
        $this->middleware('permission:delete amount', ['only' => ['delete']]);
    }

    public function index()
    {
        $amounts = Amount::get();
        return view('admin.masterdata.amounts.index', compact('amounts'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'amount_description' => ['required', 'unique:pgsql.Masterdata.amounts,amount_description', 'regex:/^[a-zA-Z0-9\s]+$/'],
                'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/']


            ],
            [
                'amount_description.required' => "Amount Description Cannot be Empty.",
                'amount_description.unique' => "Amount Description Alreaady Exist.",
                'amount_description.regex' => "Amount Description can only contain letters, numbers, and spaces.",
                'amount.required' => "Amount Cannot be empty.",
                'amount.numeric' => "Numeric Value required",
                'amount.regex' => "Pattern Mismatch"
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
            Amount::create([
                'amount_description' => $request->amount_description,
                'amount' => $request->amount
            ]);
            Alert::toast("Amounts Created Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Amounts Created Successfully!"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong.", 'error');
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
                'id' => 'required|exists:pgsql.Masterdata.amounts,id',
                 'amount_description' => ['required', 'unique:pgsql.Masterdata.amounts,amount_description,' . $request->id, 'regex:/^[a-zA-Z\s]+$/'],
                //  'amount_description' => ['required', 'unique:pgsql.Masterdata.amounts,amount_description,' . $request->id, 'regex:/^[a-zA-Z0-9\s]+$/'],
                'amount' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
            ],
            [
                'amount_description.required' => "Amount Description Cannot be Empty.",
                'amount_description.unique' => "Amount Description Alreaady Exist.",
                'amount_description.regex' => "Amount Description can only contain letters, and spaces.",
                'amount.required' => "Amount Cannot be empty.",
                'amount.numeric' => "Numeric Value required",
                'amount.regex' => "Pattern Mismatch"
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
            Amount::where('id',$request->id)->update([
                'amount_description' => $request->amount_description,
                'amount' => $request->amount
            ]);
            Alert::toast("Amounts Updated Successfully!", 'success');
            return response()->json([
                'status' => true,
                'results' => "Amounts Updated Successfully!"
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
                'amount_id' => 'required|numeric|exists:pgsql.Masterdata.amounts,id'
            ],
            [
                'amount_id.required' => "Amount Id Required",
                'amount_id.numeric' => "Amount Id can only be Numeric",
                'amount_id.exists' => "Amount Id Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Amount::where('id', $request->amount_id)->delete();
                Alert::toast("Amount Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
