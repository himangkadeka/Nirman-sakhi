<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\AgeProof;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OfficeProfileController extends Controller
{

    public function index()
    {

        return view('office.office-profile.index');
    }


    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'unique:pgsql.User.users,username,' . Auth::user()->id],
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ],
            [
                'username.required' => "Username cannot be Empty!",
                'username.unique' => "Username Already Exist",
                'firstname.required' => "First Name cannot be Empty!",
                'lastname.required' => "First Name cannot be Empty!",
                'email.required' => "Email cannot be empty",
                'phone.required' => "Phone Number cannot be empty"
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }
        try {
            $data = User::where('id', Auth::user()->id)->update([
                'username' => $request->username,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            // dd($data);
            Alert::toast("User Details Updated Successfully!", 'success');
            return redirect()->back();
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong.", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }
}
