<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform()
    {
        Log::Info('Unauthorized user '.Auth::user()->f_name.' '.Auth::user()->l_name.' was trying to log in, but rejected.');
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}