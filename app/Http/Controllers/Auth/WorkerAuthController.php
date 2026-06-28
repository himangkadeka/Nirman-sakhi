<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\User;
use App\Services\SmsGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkerAuthController extends Controller
{
    protected $smsService;
    public function __construct(SmsGatewayService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function authenticate(Request $request)
    {
        //        dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'id_card' => 'required|exists:pgsql.User.users,username',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        } else {
            $worker_mobile = User::where('username', $request->id_card)->first()->phone;
            // // stqc
            // $worker = MainWorkerForm::where('id_card', $request->id_card)->first();
            $rtpsData = session()->get('pfcData');
            $otpController = new OtpController();
            $otp =  $otpController->generateOtp($request->id_card);
            $this->smsService->loginOtpSMS($worker_mobile, $otp->otp);

            // stqc
            // session()->put('worker', $worker);
            session()->put('worker-session', true);
            return response()->json([
                'status' => true,
                // // stqc
                // 'url' => route('worker-dashboard'),
                'message' => "OTP has been sent to the Mobile Number ******" .substr($worker_mobile, -4)  . " ",
                'time_minutes' => 1,
                // 'otp' => $otp->otp
            ]);
        }
    }
}
