<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function userLog($userdetails, $status, $action)
    {
        $currentTime = Carbon::now();
        $accesstime = $currentTime->toDateTimeString();
        $server_address = $_SERVER['REMOTE_ADDR'];
        $user_log_array = array('user_id' => $userdetails->id, 'username' => $userdetails->username, 'ip_add' => $server_address, 'action' => $action, 'status' => $status, 'access_time' => $accesstime);
        UserLog::create([
            'log_details' => json_encode($user_log_array)
        ]);
    }


    public function logout()
    {
        $checkuser = Auth::user();
        $status = 'sucess';
        $action = 'logout';
        $this->userlog($checkuser, $status, $action);
        Auth::logout();
        return redirect()->route('home.index');
    }
}
