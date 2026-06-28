<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class LogVisitor
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
        $ipAddress = $request->ip();
        $visitor = Visitor::where('ip_address', $ipAddress)
            ->whereDate('visited_at', now()->toDateString())
            ->first();
        if (!$visitor) {
            Visitor::create([
                'ip_address' => $ipAddress,
            ]);
        }
        return $next($request);
    }
}
