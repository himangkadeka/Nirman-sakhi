<?php

namespace App\Http\Controllers\Admin\MISDATA;

use App\Http\Controllers\Controller;
use App\Models\WorkerSubscription;
use Illuminate\Http\Request;

class SubscriptionDataController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkerSubscription::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('worker_id', 'like', "%{$search}%")
                    ->orWhere('id_card_no', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin/mis-data/subscription/index',compact('data'));
    }
    public function edit($id)
    {
        $subscription = WorkerSubscription::findOrFail($id);
        return view('admin.mis-data.subscription.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'payment_status' => 'required',
            // add more validation as needed
        ]);

        $subscription = WorkerSubscription::findOrFail($id);
        $subscription->update($request->all());

        return redirect()->route('admin.get-subscription')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = WorkerSubscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('admin.get-subscription')->with('success', 'Subscription deleted successfully.');
    }
}
