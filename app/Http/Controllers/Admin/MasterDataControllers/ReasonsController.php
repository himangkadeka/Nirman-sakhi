<?php

namespace App\Http\Controllers\Admin\MasterDataControllers;

use App\Http\Controllers\Controller;
use App\Models\Reasons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class ReasonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:masterdata management', ['only' => ['index', 'store', 'update', 'delete']]);
        $this->middleware('permission:view reasons', ['only' => ['index']]);
        $this->middleware('permission:create reasons', ['only' => ['store']]);
        $this->middleware('permission:update reasons', ['only' => ['update']]);
        $this->middleware('permission:delete reasons', ['only' => ['delete']]);
    }
    public function index()
    {
        $reasons = Reasons::orderBy('id')->get();
        return view('admin.masterdata.reasons.index', compact('reasons'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:Revert,Reject',
            'category' => 'required|in:New Registration,Onboarding,Renewal',
            'reason' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.reasons.index')->withInput()->withErrors($validator->errors());
        }

        try {
            Reasons::create([
                'type' => $request->type,
                'category' => $request->category,
                'reason' => $request->reason,
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Alert::toast('Reason Added Successfully.', 'success');
        } catch (Exception $e) {
            Alert::toast('Something Went Wrong!', 'error');
            return redirect()->route('admin.reasons.index')->withInput();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.Masterdata.reasons,id',
            'type' => 'required|in:Revert,Reject',
            'category' => 'required|in:New Registration,Onboarding,Renewal',
            'reason' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.reasons.index')->withInput()->withErrors($validator->errors());
        }

        try {
            $reason = Reasons::where('id', $request->id)->first();
            if (!$reason) {
                Alert::toast('Reason Not Found.', 'error');
                return redirect()->route('admin.reasons.index')->withInput();
            }

            $reason->update([
                'type' => $request->type,
                'category' => $request->category,
                'reason' => $request->reason,
                'updated_at' => now(),
            ]);

            Alert::toast('Reason Updated Successfully.', 'success');
            return redirect()->route('admin.reasons.index');
        } catch (Exception $e) {
            Alert::toast('Something Went Wrong!', 'error');
            return redirect()->route('admin.reasons.index')->withInput();
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.Masterdata.reasons,id',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.reasons.index')->withInput()->withErrors($validator->errors());
        }

        try {
            $reason = Reasons::where('id', $request->id)->first();
            if (!$reason) {
                Alert::toast('Reason Not Found.', 'error');
                return redirect()->route('admin.reasons.index')->withInput();
            }

            $reason->delete();

            Alert::toast('Reason Deleted Successfully.', 'success');
            return redirect()->route('admin.reasons.index');
        } catch (Exception $e) {
            Alert::toast('Something Went Wrong!', 'error');
            return redirect()->route('admin.reasons.index')->withInput();
        }
    }

    public function updateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:pgsql.Masterdata.reasons,id',
            'status' => 'required|in:0,1',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Alert::toast($error, 'error');
            }
            return redirect()->route('admin.reasons.index')->withInput()->withErrors($validator->errors());
        }
        try {
            $reason = Reasons::where('id', $request->id)->first();
            if (!$reason) {
                foreach ($validator->errors()->all() as $error) {
                    Alert::toast($error, 'Reason Not Found');
                }
                return redirect()->route('admin.reasons.index')->withInput()->withErrors($validator->errors());
            }
            Reasons::where('id', $request->id)->update([
                'status' => $request->status,
                'updated_at' => now()
            ]);
            Alert::toast('Status Changed Sucessfully.', "success");
            return redirect()->route('admin.reasons.index');
        } catch (Exception $e) {
            Alert::toast("Something Went Wrong!", 'error');
            return redirect()->route('admin.reasons.index')->withInput();
        }
    }
}
