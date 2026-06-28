<?php

namespace App\Http\Controllers\Admin\MISData;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\RevertBack;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AlreadyRegisteredStatusController extends Controller
{
    public function index()
    {
        return RevertBack::get();
        $workerdata = MainWorkerForm::orderBy('id')
        ->where('already_registered', 1)
        ->get();
        return view('admin.mis-data.already-registered-status.index', compact('workerdata'));
    }
}
