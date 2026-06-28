<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\User;
use App\Models\UserLoginOtp;
use App\Services\SmsGatewayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class PasswordController extends Controller
{

    protected $smsService;
    public function __construct(SmsGatewayService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function index()
    {
        if (Auth::check()) {
            return view('components.change-password');
        }

        Auth::logout();
        return redirect()->route('home.index');
    }


    public function update(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'old_password' => 'required',
                    'new_password' => [
                        'required',
                        Password::min(8)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols(),
                    ],
                    'confirm_password' => 'required'
                ]
            );

            if ($validator->fails()) {
                Alert::toast($validator->errors()->first(), 'error');
                return back();
            }

            try {
                $nonceValue = 'nonce_value'; // Consider making this dynamic or configurable
                $securityController = new SecurityController();
                $decrypted_old_password = $securityController->decrypt($request->old_password, $nonceValue);
                $decrypted_new_password = $securityController->decrypt($request->new_password, $nonceValue);
                $decrypted_confirm_password = $securityController->decrypt($request->confirm_password, $nonceValue);
                if ($decrypted_new_password != $decrypted_confirm_password) {
                    Alert::toast("New Password and Confirmation Password Doesn't Matched!", 'error');
                    return back();
                }

                $user = Auth::user();
                if (Hash::check($decrypted_old_password, $user->password)) {
                    // No need to check password confirmation again here
                    $user->password = Hash::make($decrypted_new_password);
                    $user->password_change_first_attempt = true;
                    $user->save();

                    Alert::toast("Password has been Changed Successfully! Login Again", 'success');
                    Auth::logout();
                    return redirect()->route('home.index'); // Ensure this is the desired redirect
                } else {
                    Alert::toast("Invalid old Password!", 'error');
                    return back();
                }
            } catch (Exception $e) {
                Alert::toast($e->getMessage(), 'error');
                return back();
            }
        }

        return redirect()->route('home.index');
    }



    public function forgetPassword()
    {
        return view('forget-password');
    }


    public function sendOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|exists:pgsql.User.users,username',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = User::where('username', $request->username)->first();
        if ($user) {
            $otpController = new OtpController();
            $otp =  $otpController->generateOtp($request->username);
            $this->smsService->loginOtpSMS($user->phone, $otp->otp);
            return response()->json([
                'status' => true,
                'message' => "OTP Sent Successfully!",
                // 'otp' => $otp->otp,
                'username' => $request->username,
                'phone' => substr($user->phone, -4),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "User Doesn't Exist!",
            ]);
        }
    }


    public function verifyOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|exists:pgsql.User.users,username',
                'otp' => 'required|numeric|digits:6'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $loginOtp = UserLoginOtp::where('user_id', $request->username)->where('otp', $request->otp)->first();
            $now = now();

            if (!$loginOtp) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP is not Correct!"
                ]);
            } else if ($loginOtp && $now->isAfter($loginOtp->expire_at)) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP has been Expired!",

                ]);
            }
            $loginOtp->update([
                'expire_at' => now()
            ]);
            session()->put('username', $request->username);
            return response()->json([
                'status' => true,
                'message' => "OTP Verified Successfully!",
                "redirect" => route('password.reset')
            ]);
        }
    }

    public function resetPass()
    {
        $username = session()->get('username');
        $user = User::where('username', $username)->first();
        if ($user) {
            return view('reset-password', compact('username'));
        } else {
            return redirect()->route('home.index');
        }
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => [
                    'required'
                ],
                'confirm_password' => 'required'
            ]
        );

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return back();
        }

        try{
            if($request->password != $request->confirm_password){
                Alert::toast("Password and Confirm Password Doesn't Matched!", 'error');
                return back();
            }
            $username = session()->get('username');
            User::where('username', $username)->update([
                'password' => Hash::make($request->password),
                'password_change_first_attempt' => true
            ]);

            Alert::toast("Password Changed Successfully! Login Again", 'success');
            return redirect()->route('home.index');
        }catch(Exception $e){
            Alert::toast($e->getMessage(), 'error');
            return back();
        }
    }
}
