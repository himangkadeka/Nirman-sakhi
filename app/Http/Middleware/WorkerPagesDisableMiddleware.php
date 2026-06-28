<?php

namespace App\Http\Middleware;

use App\Models\MainWorkerForm;
use App\Models\WorkerIDCard;
use App\Models\WorkerSubscription;
use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class WorkerPagesDisableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
// fn
        if (session()->get('worker-session')) {
            $record['workerData'] = session()->get('worker');
            $workerId = $record['workerData']->worker_id;
            $subscription = MainWorkerForm::where('worker_id', $workerId)->first();
            $isIdCardDownloadable = WorkerIDCard::where('worker_id',$workerId)->first();

            if (isset($subscription) && isset($isIdCardDownloadable)) {
                if ($subscription->subscription_status == 0 || $isIdCardDownloadable->is_id_card_downloadble == 1) {
                    $response = $next($request);
                    return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
                } else {
                    // Optional: Use an alert to inform the user
                     Alert::warning("Please pay the subscription fee first to get full access");
                    return redirect()->route('worker-dashboard');
                }
            } else {
                // Handle cases where $subscription or $isIdCardDownloadable is null
                return redirect()->route('worker-dashboard')->with('error', 'Subscription data or ID card information is missing.');
            }

        }

        return redirect()->route('home.index');

        return $next($request);
    }
}
