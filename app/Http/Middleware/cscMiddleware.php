<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class cscMiddleware
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
        if (session()->has('worker-session')) {

            $record['workerData'] = session()->get('worker');
            $workerId = $record['workerData']->worker_id;
            $rtpsData = session('pfcData');

            if ($rtpsData) {

                $currentRoute = $request->route()->getName();   // important

                if ($rtpsData['service_id'] == 2 && $currentRoute === 'worker-subscription-new') {
                    Alert::warning("You cannot access the subscription page for this service.");
                    return redirect()->route('worker-dashboard');
                }

                if ($rtpsData['service_id'] == 3 && $currentRoute === 'renew-application') {
                    Alert::warning("Use Renewal Service from sewasetu to submit Renewal application.");
                    return redirect()->route('worker-dashboard');
                }
            }
        }

        return $next($request);
    }

}
