<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LogController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUser
{
    protected $logcontroller;
    public function __construct(LogController $logcontroller)
    {

        $this->logcontroller = $logcontroller;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 1) {
            if (Auth::user()->password_change_first_attempt == false) {
                return redirect()->route('password.change');
            } else {
                $response = $next($request);
                if (method_exists($response, 'header')) {
                return $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
                    ->header('Pragma', 'no-cache')
                    ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
            }
            return $response;
        }
        } else if (Auth::check()) {
            $this->logcontroller->logout();
        }

        return redirect()->route('home.index');

        return $next($request);
    }
}
