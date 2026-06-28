<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\PostOffice;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PostOfficeController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view subdistrict', ['only' => ['index','search']]);
        $this->middleware('permission:create subdistrict', ['only' => ['store']]);
        $this->middleware('permission:update subdistrict', ['only' => ['update']]);
        $this->middleware('permission:delete subdistrict', ['only' => ['delete']]);
    }


    public function index()
    {
        $states = State::where('status', 1)->orderBy('state_name')->get();
        return view('admin.masterdata.post-office.index', compact('states'));
    }



    public function search(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'state_code' => 'required|exists:pgsql.Masterdata.states,state_code',
            'district_code' => 'required|exists:pgsql.Masterdata.districts,district_code'
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
        $post_offices = PostOffice::where('district_code', $request->district_code)
            ->where('state_code', $request->state_code)
            ->get();

        if ($post_offices->count() > 0) {
            foreach ($post_offices as $key => $post_office) {
                $editButton = '';
                $deleteButton = '';

                if (auth()->user()->can('update postoffice')) {
                    $editButton = '<button data-toggle="modal" data-target="#post-office-edit-modal"
                        onclick="editPostofficemodal(' . $post_office->post_office_id . ', \'' . htmlspecialchars($post_office->districts->district_name, ENT_QUOTES) . '\', \'' . htmlspecialchars($post_office->states->state_name, ENT_QUOTES) . '\', ' . $post_office->pin_code . ', \'' . htmlspecialchars($post_office->post_office_name, ENT_QUOTES) . '\');"
                        aria-hidden="true" style="border: none; background: none; padding: 0; cursor: pointer;">
                        <i class="fas fa-edit" style="color: #12d3d0;"></i>
                    </button>';
                }

                if (auth()->user()->can('delete postoffice')) {
                    $deleteButton = '<i onclick="confirmDelete(' . $post_office->post_office_id . ', \'PostOffice\')"
                        class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px; cursor: pointer;"></i>';
                }

                $table_data .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . htmlspecialchars($post_office->post_office_name, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($post_office->pin_code, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($post_office->districts->district_name, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($post_office->states->state_name, ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($post_office->created_at, ENT_QUOTES) . '</td>
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
            'results' => $e->getMessage() // Return error message instead of object
        ]);
    }
}



    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'state_code' => 'required|numeric|exists:pgsql.Masterdata.states,state_code',
                'district_code' => 'required|numeric|exists:pgsql.Masterdata.districts,district_code',
                'pin_code' => 'required|digits:6|unique:pgsql.Masterdata.post_offices,pin_code',
                'post_office_name' => 'required|regex:/^[\pL\s]+$/u|unique:pgsql.Masterdata.post_offices,post_office_name'
            ],
            [
                'state_code.required' => "State Cannot be Empty!",
                'state_code.numeric' => "State Name can only be Numeric",
                'district_code.required' => "District Cannot be Empty!",
                'district_code.numeric' => "District Name can only be Numeric",
                'pin_code.required' => "PIN Code Cannot be Empty!",
                'pin_code.numeric' => "PIN Code can only be Numeric",
                'pin_code.unique' => "PIN Code already Exist",
                'post_office_name.required' => "Post Office Name Cannot be Empty",
                'post_office_name.regex' => "Post Office can contain only letters and space",
                'post_office_name.unique' => "Posst Office Name already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                "status" => false,
                "results" => $validator->errors()
            ]);
        }

        try {
            PostOffice::create([
                'post_office_name' => $request->post_office_name,
                'pin_code' => $request->pin_code,
                'district_code' => $request->district_code,
                'state_code' => $request->state_code
            ]);
            Alert::toast("Post Office Added Successfully", 'success');
            return response()->json([
                "status" => true,
                "results" => "Post Office Added Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                "status" => false,
                "results" => $e
            ]);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:pgsql.Masterdata.post_offices,post_office_id',
                'pin_code' => 'required|digits:6',
                'post_office_name' => 'required|regex:/^[\pL\s]+$/u|unique:pgsql.Masterdata.post_offices,post_office_name'
            ],
            [
                'pin_code.required' => "PIN Code Cannot be Empty!",
                'pin_code.numeric' => "PIN Code can only be Numeric",
                'post_office_name.required' => "Post Office Name Cannot be Empty",
                'post_office_name.regex' => "Post Office can contain only letters and space",
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return response()->json([
                "status" => false,
                "results" => $validator->errors()
            ]);
        }

        try {
            PostOffice::where('post_office_id', $request->id)->update([
                'post_office_name' => $request->post_office_name,
                'pin_code' => $request->pin_code,
            ]);
            Alert::toast("Post Office Updated Successfully", 'success');
            return response()->json([
                "status" => true,
                "results" => "Post Office Updated Successfully"
            ]);
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                "status" => false,
                "results" => $e
            ]);
        }
    }


    public function delete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'post_office_code' => 'required|numeric|exists:pgsql.Masterdata.post_offices,post_office_id'
            ],
            [
                'post_office_code.required' => "Post Office Code Required",
                'post_office_code.numeric' => "Post Office Code can only be Numeric",
                'post_office_code.exists' => "Post Office Code Already Exist"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        } else {
            try {
                PostOffice::where('post_office_id', $request->post_office_code)->delete();
                Alert::toast("Post Office Deleted Successfully", 'success');
                return back();
            } catch (Exception $e) {
                Alert::toast("Something went Wrong", 'error');
                return back();
            }
        }
    }
}
