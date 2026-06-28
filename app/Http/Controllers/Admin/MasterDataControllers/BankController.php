<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BankController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view bank', ['only' => ['index','search']]);
        $this->middleware('permission:create bank', ['only' => ['store']]);
        $this->middleware('permission:update bank', ['only' => ['update']]);
        $this->middleware('permission:delete bank', ['only' => ['delete']]);
    }
    public function index()
    {

        $banks = Bank::select('bank_name', 'state')
            ->distinct()
            ->orderBy('state')
            ->get();
        // $banks = Bank::where('bank_name','STATE BANK OF INDIA')->get();
        $states = State::where('status', 1)->get();
        return view('admin.masterdata.bank-detail.index', compact('banks', 'states'));
    }

    public function search(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'bank_name' => 'required|exists:pgsql.Masterdata.banks,bank_name'
        ]
    );

    if ($validator->fails()) {
        Alert::toast($validator->errors()->first(), 'error');
        return response()->json([
            'status' => false,
            'results' => $validator->errors()
        ]);
    }

    $table_data = "";

    try {
        $banks = Bank::where('bank_name', $request->bank_name)->get();

        if ($banks->count() > 0) {
            foreach ($banks as $key => $bank) {
                // Permission check for update
                $editButton = '';
                if (auth()->user()->can('update bank')) {
                    $editButton = '<button data-toggle="modal" data-target="#bank-edit-modal"
                        onclick="editBank(' . $bank->id . ', \'' . htmlspecialchars($bank->state, ENT_QUOTES) . '\', \'' . htmlspecialchars($bank->ifsc, ENT_QUOTES) . '\', \'' . htmlspecialchars($bank->branch_name, ENT_QUOTES) . '\', \'' . htmlspecialchars($bank->bank_name, ENT_QUOTES) . '\');"
                        aria-hidden="true" style="border: none; background: none; padding: 0; cursor: pointer;">
                        <i class="fas fa-edit" style="color: #12d3d0;"></i>
                    </button>';
                }

                // Permission check for delete
                $deleteButton = '';
                if (auth()->user()->can('delete bank')) {
                    $deleteButton = '<i onclick="confirmDelete(' . $bank->id . ', \'Bank\')"
                        class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px; cursor: pointer;"></i>';
                }

                // Building the table row
                $table_data .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . htmlspecialchars($bank->state, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($bank->ifsc, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($bank->branch_name, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($bank->bank_name, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($bank->created_at, ENT_QUOTES) . '</td>
                    <td>' . $editButton . $deleteButton . '</td>
                </tr>';
            }

            Alert::toast("Data Found!", 'success');
            return response()->json([
                'status' => true,
                'results' => $table_data
            ]);
        } else {
            Alert::toast("No Data Found!", 'success');
            return response()->json([
                'status' => false,
                'results' => "No Data Found!"
            ]);
        }
    } catch (Exception $e) {
        Alert::toast("Something went Wrong!", 'error');
        return response()->json([
            'status' => false,
            'results' => $e->getMessage() // Return only the message
        ]);
    }
}


    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [


                'state_code' => 'required',

                'ifsc_code' => 'required|regex:/^[a-zA-Z0-9]+$/',
                'branch_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'bank_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'state_code.required' => "State Cannot be Empty!",
                'ifsc_code.regex' => "IFSC code can only contain letters and numbers",
                'branch_name.required' => "Branch Name Cannot be Empty!",
                'branch_name.regex' => "Branch Name can only contain letters and space",
                'bank_name.required' => "Bank Name Cannot be Empty",
                'bank_name.regex' => "Bank Name can only contain letters and space"
            ]
        );

        // Handle validation failure
        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                "status" => false,
                "results" => $validator->errors()
            ]);
        }

        $sanitizeBankData = [
            'state' => $request->state_code,
            'ifsc' => $request->ifsc_code,
            'branch_name' => $request->branch_name,
            'bank_name' => $request->bank_name,
        ];

        try {
            // Save to database
            Bank::create($sanitizeBankData);

            Alert::toast("Bank Added Successfully", 'success');
            return response()->json([
                "status" => true,
                "results" => "Bank Added Successfully"
            ]);
        } catch (Exception $e) {

            // Provide a generic error message to the user
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                "status" => false,
                "results" => $e->getMessage()
            ]);
        }
    }



    public function update(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [

                'id' => 'required|exists:pgsql.Masterdata.banks,id',

                'ifsc_code' => 'required|regex:/^[a-zA-Z0-9]+$/',
                'branch_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'bank_name' => 'required|regex:/^[a-zA-Z\s]+$/'
            ],
            [
                'id.required' => "Bank ID is required!",
                'id.exists' => "The specified Bank ID does not exist.",
                'ifsc_code.required' => "IFSC Code Cannot be Empty!",
                'ifsc_code.regex' => "IFSC code can only contain letters and numbers",
                'bank_name.required' => "Bank Name Cannot be Empty",
                'bank_name.regex' => "Bank Name can only contain letters and space",
                'branch_name.required' => "Branch Name Cannot be Empty",
                'branch_name.regex' => "Branch Name can only contain letters and space"
            ]
        );


        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                "status" => false,
                "results" => $validator->errors()
            ]);
        }


        $sanitizeBankData = [
            'ifsc' => $request->ifsc_code,
            'branch_name' => $request->branch_name,
            'bank_name' => $request->bank_name,
        ];

        try {

            Bank::where('id', $request->id)->update($sanitizeBankData);

            Alert::toast("Bank Updated Successfully", 'success');
            return response()->json([
                "status" => true,
                "results" => "Bank Updated Successfully"
            ]);
        } catch (Exception $e) {


            // Return a generic error message
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                "status" => false,
                "results" => $e->getMessage()
            ]);
        }
    }



    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'bank_code' => 'required|numeric|exists:pgsql.Masterdata.banks,id'
            ],
            [
                'bank_code.required' => "Post Office Code Required",
                'bank_code.numeric' => "Post Office Code can only be Numeric",
                'bank_code.exists' => "Post Office Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                Bank::where('id', $request->bank_code)->delete();
                Alert::toast("Bank Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
