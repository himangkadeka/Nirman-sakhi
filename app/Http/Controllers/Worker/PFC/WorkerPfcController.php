<?php

namespace App\Http\Controllers\Worker\PFC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkerPfcController extends Controller
{
    public function sessionFlash()
    {
        Session::flush();
        session()->regenerate();
        return redirect()->route('home.index');
    }

    public function getPFCData($id)
    {
        $data = decrypt($id);

        return view('worker-pfc-registration',compact('data'));
    }

    public function savePfcData(Request $request)
    {

        return redirect()->route('new-registration');
    }

    public function newRegistration(Request $request)
    {
        $data['dists'] = DB::table('Masterdata.districts')
            ->where('state_code', '=', 18)
            ->orderBy('district_name')
            ->get();
        return view('worker.worker-pfc-new-register',$data);
    }
}
