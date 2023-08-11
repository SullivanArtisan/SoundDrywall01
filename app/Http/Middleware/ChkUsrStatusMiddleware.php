<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChkUsrStatusMiddleware
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
        if (Auth::user()->status == 'DELETED') {
            MyHelper::LogStaffActionResult(Auth::user()->id, 'The DELETED staff tried to log in, but rejected.', '500');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('usr_status_error', 'Oops, something wrong with your account. Please contact Admin.');
        } else {
            return $next($request);
        }
    }
}
