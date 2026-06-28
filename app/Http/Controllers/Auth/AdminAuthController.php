<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserLoginOtp;
use App\Services\SmsGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminAuthController extends Controller
{
    protected $smsService;
    public function __construct(SmsGatewayService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|exists:pgsql.User.users,username',
                'password' => 'required|min:8',
                'captcha' => 'required|captcha'
            ],
            [
                'username.required' => 'Username Cannot be Blank',
                'username.exist' => "Username doesn't Exist!",
                'password.required' => 'Password Cannot be Blank',
                'password.min' => 'Password Must Contain Minimum 8 Characters',
                'captcha.required' => 'Captcha Cannot be Blank',
                'captcha.captcha' => 'Captcha Does Not Match'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $nonceValue = 'nonce_value';
            $securityController = new SecurityController();
            $decryptedPassword = $securityController->decrypt($request->password, $nonceValue);
            $checkUser = User::where('username', $request->username)->first();
            if ($checkUser && $checkUser->role_id == 1 && $checkUser->status == 1 && Hash::check($decryptedPassword, $checkUser->password)) {

                session()->put('user_password', $request->password);
                $otpController = new OtpController();
                $otp =  $otpController->generateOtp($request->username);
                $this->smsService->loginOtpSMS($checkUser->phone, $otp->otp);
                return response()->json([
                    'status' => true,
                    'message' => "OTP Sent Successfully!",
                    // 'otp' => $otp->otp,
                    'username' => $request->username,
                    'phone' => substr($checkUser->phone, -4),
                ]);
            } else {
                $status = 'fail';
                $action = 'login';
                $checkuser = (object)array('id' => 0, 'username' => $request->username);
                $userlog = new LogController();
                $userlog->userlog($checkuser, $status, $action);
                Alert::toast('User Does Not Exist or Password Mismatch', 'error');
                return response()->json([
                    'status' => false,
                    'results' => 0
                ]);
            }
        }
    }



}
