<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SecurityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Abaocwwb;
use App\Models\User;
use App\Models\UserLoginOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    protected $userinfo;
    public function __construct(Abaocwwb $user)
    {
        $this->userinfo = $user;
    }
    public function index()
    {
        return view('admin.userlogin');
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }


   

    

 
   

    





    

    
    
    public function userlog($checkuser, $status, $action)
    {
        $currentTime = Carbon::now();
        $accesstime = $currentTime->toDateTimeString();
        $server_add = $_SERVER['REMOTE_ADDR'];
        $userlogarr = array('user_id' => $checkuser[0]->id, 'username' => $checkuser[0]->username, 'ip_add' => $server_add, 'action' => $action, 'status' => $status, 'access_time' => $accesstime);
        $userlogarr_json = json_encode($userlogarr);
        $userlogdetail = array('log_details' => $userlogarr_json);
        $tablename = 'User.userlogs';
        $this->userinfo->insertData($tablename, $userlogdetail);
    }
}
