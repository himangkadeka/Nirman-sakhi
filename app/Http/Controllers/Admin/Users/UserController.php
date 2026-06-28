<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\District;
use App\Models\Office;
use App\Models\User;
use App\Models\UserTransfer;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['store']]);
        $this->middleware('permission:update user', ['only' => ['update', 'updateStatus']]);
    }

    public function index()
    {
        $users = User::where('role_id', '<>', 6)->orderBY('id')->get();
        $designations = Designation::orderBy('id')->get();
        $offices = Office::get();
        $roles = Role::where('id', '<>', 6)->get();
        $dists = District::where('state_code', '=', 18)->get();
        return view('admin.user-management.users.index', compact('users', 'designations', 'offices', 'roles', 'dists'));
    }
    public function indexTransfer()
    {
        $users = UserTransfer::orderBy('id', 'asc')->get(); // keep original order by ID

        $designations = Designation::orderBy('id')->get();
        $offices = Office::get();
        $roles = Role::where('id', '<>', 6)->get();
        $dists = District::where('state_code', '=', 18)->get();
        return view('admin.user-management.users.transfer-index', compact('users', 'designations', 'offices', 'roles', 'dists'));
    }



    public function viewDocument($filename)
    {
        $path = 'transfer-documents/' . $filename;

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType);
    }



    private function remove_sp_chr($str)
    {
        $result = str_replace(array("@", "."), array("[at]", "[dot]"), $str);
        return $result;
    }



    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'user_name' => 'required|max:20|unique:pgsql.User.users,username',
                'password' => [
                    'required',
                    'confirmed', // ensures 'password' and 'password_confirmation' match
                    Password::min(8) // minimum 8 characters
                        ->mixedCase()  // requires both upper and lower case letters
                        ->letters()    // requires at least one letter
                        ->numbers()    // requires at least one number
                        ->symbols(),   // requires at least one symbol
                ],
                'password_confirmation' => 'required|same:password',
                'firstname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'phone' => 'required|digits:10',
                'email' => 'nullable|email',
                'designation' => 'required|exists:pgsql.Masterdata.designations,id',
                'district' => 'required|exists:pgsql.Masterdata.districts,district_code',
                'office_id' => 'required|numeric|exists:pgsql.Masterdata.offices,office_id',
                'role_name' => 'required|numeric|exists:pgsql.User.roles,id',
            ],
            [
                'user_name.required' => 'Username cannot be empty.',
                'user_name.max' => 'Username must be 20 characters.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
                'firstname.required' => 'First name is required.',
                'lastname.required' => 'Last name is required.',
                'phone.required' => 'Phone number is required.',
                'phone.min' => 'Phone number must be at least 10 digits.',
                'phone.numeric' => 'Phone number must contain only digits.',
                'designation.required' => 'Designation is required.',
                'office_id.required' => 'Office name is required.',
                'district.required' => 'District name is required.',
                'role_name.required' => 'Role name is required.',
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
            DB::beginTransaction();
            $user = User::create([
                'username' => $request->user_name,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $this->remove_sp_chr($request->email),
                'password' => Hash::make($request->password),
                'role_id' => $request->role_name,
                'office_id' => $request->office_id,
                'district' => $request->district,
                'designation_id' => $request->designation,
                'status' => 0,
                'password_change_first_attempt' => false
            ]);
            $role_name = Role::where('id', $request->role_name)->first()->name;
            $user->syncRoles([$role_name]);
            DB::commit();
            Alert::toast("User Created Successfully.", 'success');
            return response()->json([
                'status' => true,
                'results' => "User Created Successfully."
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }


    public function update(Request $request)
    {
        // return $request->all();
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:pgsql.User.users,id',
                'user_name' => 'required|max:20|unique:pgsql.User.users,username,' . $request->id,
                'firstname' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'phone' => 'required|digits:10',
                'email' => 'nullable|email',
                'designation' => 'required|exists:pgsql.Masterdata.designations,id',
                'district' => 'required|exists:pgsql.Masterdata.districts,district_code',
                'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
                'role_name' => 'required|exists:pgsql.User.roles,id',
            ],
            [
                'user_name.required' => 'Username cannot be empty.',
                'user_name.max' => 'Username must be 20 characters.',
                'firstname.required' => 'First name is required.',
                'lastname.required' => 'Last name is required.',
                'phone.required' => 'Phone number is required.',
                'phone.min' => 'Phone number must be at least 10 digits.',
                'phone.numeric' => 'Phone number must contain only digits.',
                'designation.required' => 'Designation is required.',
                'office_id.required' => 'Office name is required.',
                'district.required' => 'District name is required.',
                'role_name.required' => 'Role name is required.',
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

            $user = User::findOrFail($request->id); // Get the user instance

            // Update the user attributes
            $user->update([
                'username' => $request->user_name,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $this->remove_sp_chr($request->email),
                'role_id' => $request->role_name,
                'office_id' => $request->office_id,
                'district' => $request->district,
                'designation_id' => $request->designation,
                'is_incharge' => $request->is_incharge
            ]);
            $role_name = Role::where('id', $request->role_name)->first()->name;
            $user->syncRoles([$role_name]);
            Alert::toast("User Updated Successfully.", 'success');
            return response()->json([
                'status' => true,
                'results' => "User Updated Successfully."
            ]);
        } catch (Exception $e) {
//            return $e;
            Alert::toast("Something Went Wrong!", 'error');
            return response()->json([
                'status' => false,
                'results' => $e
            ]);
        }
    }

    //transfer module
    public function transferUser(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:pgsql.User.users,id',
                'user_name' => 'required|max:20',
                'firstname' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'phone' => 'required|digits:10',
                'email' => 'nullable|email',
                'designation' => 'required|exists:pgsql.Masterdata.designations,id',
//                'district' => 'required|exists:pgsql.Masterdata.districts,district_code',
//                'office_id' => 'required|exists:pgsql.Masterdata.offices,office_id',
                'role_name' => 'required|exists:pgsql.User.roles,id',
                'transfer_from_district' => 'exists:pgsql.Masterdata.districts,district_code',
                'transfer_to_district' => 'exists:pgsql.Masterdata.districts,district_code',
                'transfer_from_office' => 'exists:pgsql.Masterdata.offices,office_id',
                'transfer_to_office' => 'exists:pgsql.Masterdata.offices,office_id',
                'transfer_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:1048'
            ],
            [
                'user_name.required' => 'Username cannot be empty.',
                'user_name.max' => 'Username must be 20 characters.',
                'firstname.required' => 'First name is required.',
                'lastname.required' => 'Last name is required.',
                'phone.required' => 'Phone number is required.',
                'phone.min' => 'Phone number must be at least 10 digits.',
                'phone.numeric' => 'Phone number must contain only digits.',
                'designation.required' => 'Designation is required.',
//                'office_id.required' => 'Office name is required.',
//                'district.required' => 'District name is required.',
                'role_name.required' => 'Role name is required.',
                'transfer_document.required' => 'Please upload a transfer or relieving document.',
                'transfer_document.mimes' => 'Only PDF, JPG, or PNG files are allowed.',
                'transfer_document.max' => 'File size should not exceed 2MB.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        try {

            $endDateTime = Carbon::parse($request->officers_end_date)->setTimeFrom(Carbon::now());
            $retirementDateTime = Carbon::parse($request->retired_at)->setTimeFrom(Carbon::now());
            $documentPath = null;
            if ($request->hasFile('transfer_document')) {
                $file = $request->file('transfer_document');

                // Get file extension safely
                $extension = $file->extension();

                // Generate unique name using UUID
                $uuid = Str::uuid();

                // Build custom file name and path inside private storage
                $transfer_doc = 'transfer-documents/' . $request->firstname . '.' . $uuid . '.' . $extension;
//                $filename = "transfer_documents/transfer_{$request->user_id}_{$uuid}.{$extension}";

                // Save file manually to the configured 'public' disk (points to storage/app/private)
                Storage::disk('public')->put($transfer_doc, file_get_contents($file->getRealPath()));

                // Save relative path to database
                $filePath = "/private/{$transfer_doc}";

            }


            // Create a new user
            $userTransfer = UserTransfer::create([
                'user_id' => $request->user_id,
                'username' => $request->user_name,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $this->remove_sp_chr($request->email),
                'role' => $request->role_name,
                'designation' => $request->designation,
                'is_retired' => $request->is_retired,
                'retired_at' => $retirementDateTime,
                'is_incharged' => $request->is_incharged,
                'tenure_end_date' => $endDateTime,
                'transfer_from_district' => $request->district_from,
                'transfer_to_district' => $request->district_to,
                'transfer_from_office' => $request->office_id_from,
                'transfer_to_office' => $request->office_id_to,
                'transfer_document' => $filePath,
            ]);

            // Assign role using Spatie
//            $role_name = Role::where('id', $request->role_name)->first()->name;
//            $user->assignRole($role_name);

            return response()->json([
                'status' => true,
                'message' => 'User transfer saved successfully.',
                'data' => $userTransfer
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.User.users,id',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.users.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $user = User::where('id', $request->id)->first();
            if (!$user) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'User Not Found');
                }
                return redirect()->route('admin.users.index')->withInput()->withErrors($validator->errors());
            }
            User::where('id', $request->id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.users.index')->withInput();
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pgsql.User.users,id',
        ], [
            'id.required' => 'User ID is required.',
            'id.exists' => 'The user does not exist.',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->route('admin.users.index');
        }

        try {
            $user = User::where('id', $request->id)
                    ->first();

            if (!$user) {
                Alert::toast('User not found.', 'error');
                return response()->json([
                    'status' => false,
                    'results' => 'User not found.',
                ]);
            }

            $user->update([
                'password' => Hash::make($user->username),
                'password_change_first_attempt' => False
            ]);

            Alert::toast('Password reset successfully. The new password is the username.', 'success');
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            Alert::toast('Something went wrong while resetting the password.', 'error');
            return redirect()->route('admin.users.index');
        }
    }


    public function updateTransferDocument(Request $request, $id)
    {
        $user = UserTransfer::findOrFail($id);

        if ($request->hasFile('transfer_document')) {

            $file = $request->file('transfer_document');

            $extension = $file->extension();

            $uuid = Str::uuid();

            $transferDocName = 'transfer-documents/' . $user->firstname . '.' . $uuid . '.' . $extension;

            Storage::disk('public')->put($transferDocName, file_get_contents($file->getRealPath()));

            $filePath = "/private/{$transferDocName}";

            if (!empty($user->transfer_document)) {
                $oldFile = str_replace('/private/', '', $user->transfer_document);
                Storage::disk('public')->delete($oldFile);
            }

            $user->transfer_document = $filePath;
            $user->save();
        }

        return redirect()->back()->with('success', 'Transfer document updated successfully!');
    }

    public function deleteDocument($id)
    {
        $user = UserTransfer::findOrFail($id);

        if ($user->transfer_document && file_exists(public_path('uploads/transfer_docs/' . $user->transfer_document))) {
            unlink(public_path('uploads/transfer_docs/' . $user->transfer_document));
        }

        // Set column to null
        $user->transfer_document = null;
        $user->save();

        return back()->with('success', 'Document deleted successfully.');
    }

}
