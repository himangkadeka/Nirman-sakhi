<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\MainWorkerForm;
use App\Models\NomineeRegistration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class NomineeManagementController extends Controller
{
    public function index()
    {
        $workerIds = MainWorkerForm::where('office_id', Auth::user()->office_id)->pluck('worker_id');
        $nominees = NomineeRegistration::whereIn('worker_id', $workerIds)->paginate(20);
        return view('office.nominee.index', compact('nominees'));
    }


    public function reject(Request $request, NomineeRegistration $nominee)
    {
        // Validate that a reason was provided
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Update the status and store the reason
        $nominee->status = 2;
        $nominee->rejected_by = Auth::user()->id;
        $nominee->rejected_at = Carbon::now();
        $nominee->rejected_reason = $request->input('rejection_reason');
        $nominee->save();

        Alert::success('Nominee has been rejected');
        return redirect()->back()->with('success', 'Nominee has been rejected.');
    }

    public function approve(Request $request, NomineeRegistration $nominee)
    {
        $id_card_data = MainWorkerForm::select('id_card','worker_id','office_id','district')->where('worker_id', $nominee->worker_id)->first();
        $count = NomineeRegistration::where('worker_id', $nominee->worker_id)->where('status', 1)->count()+1;
        $nominee->status = 1;
        $nominee->approved_by = Auth::user()->id;
        $nominee->approved_at = Carbon::now();
        $nominee->nomine_id = $id_card_data->id_card . "-N" . $count;
        // $nominee->rejected_reason = $request->input('rejection_reason');
        $nominee->save();
        $user = User::Create([
            'username' => $id_card_data->id_card . "-N" . $count,
            'password' => Hash::make($id_card_data->id_card . "-N" . $count),
            'firstname' => $nominee->name,
            'lastname' => '-',
            'phone' => $nominee->phone,
            'email' => '-',
            'role_id' => $nominee->nominee_or_legal==0?10:11,
            'office_id' => $id_card_data->office_id,
            'district' => $id_card_data->district,
            'status' => 1
        ]);

        Alert::success('Nominee has been Approved');
        return redirect()->back()->with('success', 'Nominee has been Approved.');
    }
}
