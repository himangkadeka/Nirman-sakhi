<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class WorkerProfileController extends Controller
{
    public function getProfile()
    {
        $record['worker'] = session()->get('user');
        return view('Worker/workerProfile',$record);
    }

    public function basicDetails()
    {
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
            ->join('Masterdata.genders as gen', 'wmbd.gender', '=', 'gen.gender_code')
            ->join('Masterdata.categories as cat', 'wmbd.category', '=', 'cat.category_code')
            ->where('wfm.worker_id', $workerValue->worker_id)
            ->select('wfm.*', 'wmbd.*', 'gen.*', 'cat.*')
            ->first();
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['add'] = DB::table('Worker.main_worker_addresses')->where('worker_id', $workerId)->first();
        $data['wfd'] = DB::table('Worker.main_worker_families')->where('worker_id', $workerId)->get();

        return view('worker.profile-tabs.basic-profile-details', $data);

    }

    public function familyDetails(){
        if (session()->get('worker-session') != true) {
            return Redirect::to('/');
        }
        $record['worker'] = $workerValue = session()->get('worker');
        $workerId = $record['worker']->worker_id;
        $data['user'] = DB::table('Worker.main_worker_forms as wfm')
            ->join('Worker.main_worker_basic_details as wmbd', 'wfm.worker_id', '=', 'wmbd.worker_id')
            ->join('Masterdata.genders as gen', 'wmbd.gender', '=', 'gen.gender_code')
            ->join('Masterdata.categories as cat', 'wmbd.category', '=', 'cat.category_code')
            ->where('wfm.worker_id', $workerValue->worker_id)
            ->select('wfm.*', 'wmbd.*', 'gen.*', 'cat.*')
            ->first();
        $data['wmf'] = DB::table('Worker.main_worker_forms')->where('worker_id', $workerId)->first();
        $data['renewal_date'] = Carbon::parse($data['wmf']->renewal_date);
        $data['wrkr'] = DB::table('Worker.main_worker_basic_details')->where('worker_id', $workerId)->first();
        $data['add'] = DB::table('Worker.main_worker_addresses')->where('worker_id', $workerId)->first();
        $data['wfd'] = DB::table('Worker.main_worker_families')->where('worker_id', $workerId)->get();

        return view('worker.profile-tabs.family-profile-details', $data);
    }
}
