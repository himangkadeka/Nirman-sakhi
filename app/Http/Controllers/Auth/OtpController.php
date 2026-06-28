<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use App\Models\MainWorkerForm;
use App\Models\PfcKioskDetail;
use App\Models\User;
use App\Models\UserLoginOtp;
use App\Services\SmsGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OtpController extends Controller
{
    // protected $smsService;
    // public function __construct(SmsGatewayService $smsService)
    // {
    //     $this->smsService = $smsService;
    // }
    public function generateOtp($user_id)
    {
        $user = User::where('username', $user_id)->first();
        $user_otp = UserLoginOtp::where('user_id', $user->username)->latest()->first();
        $now = now();

        if ($user_otp && $now->isBefore($user_otp->expire_at)) {
            return $user_otp;
        }

        return UserLoginOtp::create([
            'user_id' => $user->username,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(4)
        ]);
    }


    // public function sendOtp(Request $request)
    // {
    //     $user_otp = UserLoginOtp::where('user_id', $request->username)->latest()->first();
    //     $now = now();

    //     if ($user_otp && $now->isBefore($user_otp->expire_at)) {
    //         return $user_otp;
    //     }
    //     $worker_mobile = User::where('username', $request->id_card)->first()->phone;


    //     $detail = UserLoginOtp::create([
    //         'user_id' => $request->username,
    //         'otp' => rand(123456, 999999),
    //         'expire_at' => $now->addMinutes(2)
    //     ]);
    //     $this->smsService->loginOtpSMS($worker_mobile, $otp->otp);

    //     return response()->json([
    //         'message' => "OTP has been sent to the Mobile Number ******" .substr($worker_mobile, -4)  . " ",
    //         'status' => true,
    //         'time_minutes' => 1
    //     ]);
    // }

    public function sendOtp(Request $request)
    {
        $otp = $this->generateOtp($request->username);
        $worker_mobile = User::where('username', $request->username)->first()->phone;
        $smsService = new SmsGatewayService();
        $smsService->loginOtpSMS($worker_mobile, $otp->otp);

        // stqc
        // session()->put('worker', $worker);
        session()->put('worker-session', true);
        return response()->json([
            'status' => true,
            // // stqc
            // 'url' => route('worker-dashboard'),
            'message' => "OTP has been sent to the Mobile Number ******" . substr($worker_mobile, -4)  . " ",
            'time_minutes' => 4,
            // 'otp' => $otp->otp
        ]);
    }


    public function otpVerification(Request $request)
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
                    'message' => "Your OTP has been Expired!"
                ]);
            }
            $nonceValue = 'nonce_value';
            $securityController = new SecurityController();
            $decryptedPassword = $securityController->decrypt(session()->get('user_password'), $nonceValue);
            $checkuser = User::where('username', $request->username)->first();
            if ($checkuser && $checkuser->status == 1) {
                if (Auth::attempt([
                    'username' => $request->username,
                    'password' => $decryptedPassword,
                    'status' => 1,
                ])) {
                    $loginOtp->update([
                        'expire_at' => now()
                    ]);
                    $userData = Auth::user();
                    $status = 'sucess';
                    $action = 'login';
                    $userlog = new LogController();
                    $userlog->userlog($userData, $status, $action);
                    if ($userData->role_id == 1) {
                        $redirect = route('admin.dashboard.index');
                    } elseif ($userData->role_id != 6) {
                        $redirect = route('office.dashboard.index');
                    }

                    Alert::toast('Login Successfull!', 'success');
                    return response()->json([
                        'status' => true,
                        'msg' => "Login Successfull!",
                        'redirect' => $redirect
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'msg' => "Verification failed!"
                    ]);
                }
            }
        }
    }

    public function workerOtpVerification(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id_card' => 'required|exists:pgsql.User.users,username',
                'otp' => 'required|numeric|digits:6',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $loginOtp = UserLoginOtp::where('user_id', $request->id_card)->where('otp', $request->otp)->first();
            $now = now();

            if (!$loginOtp) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP is not Correct!"
                ]);
            } else if ($loginOtp && $now->isAfter($loginOtp->expire_at)) {
                return response()->json([
                    'status' => false,
                    'message' => "Your OTP has been Expired!"
                ]);
            }

            if (strpos($request->id_card, '-') !== false) {
                $result = strstr($request->id_card, '-', true);
                session()->put('nominee', $request->id_card);
            } else {
                $result = $request->id_card;
            }
            $worker = MainWorkerForm::where('id_card', $result)->first();
            // return $worker;
            if (session()->has('pfcData')) {
                $pfcData = session()->get('pfcData');
                PfcKioskDetail::where('rtps_trans_id', $pfcData->rtps_trans_id)->update([
                    'isLoginWithPfc' => true,
                    'worker_id' => $request->id_card
                ]);
            }
            $user = User::where('username', $request->id_card)->first();
            if ($user->role_id == 6) {
                $loginOtp->update([
                    'expire_at' => now()
                ]);
                session()->put('worker', $worker);
                // $test = session()->get('worker');
                // return $test;
                session()->put('worker-session', true);
                // Alert::toast('Login Successful!','success');
                return response()->json([
                    'status' => true,
                    'message' => "Login Successful!",
                    'redirect' => route('worker-dashboard')
                ]);
            } elseif ($user->role_id == 10 || $user->role_id == 11) {
                $loginOtp->update([
                    'expire_at' => now()
                ]);
                session()->put('worker', $worker);
                session()->put('worker-session', true);
                // Alert::toast('Login Successful!','success');
                return response()->json([
                    'status' => true,
                    'message' => "Login Successful!",
                    'redirect' => route('nominee.dashboard')
                ]);
            }
        }
    }
}
