<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerBasicDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class WorkerPAddressOutOfAssamController extends Controller
{
    public function index()
    {
        $workers = MainWorkerBasicDetail::orderBy('id')
            ->where('resident_type', '=', 'rao')
            ->with('mainWorkerForm')
            ->get();
        $count=MainWorkerBasicDetail::where('resident_type', '=', 'rao')->count();

        return view('admin.mis-data.worker-paddress-data.index', compact('workers','count'));

    }
}
