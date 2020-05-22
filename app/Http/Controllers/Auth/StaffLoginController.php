<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class StaffLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:staff')->except('logout');
    }

    public function showStaffLoginForm()
    {
        return view('staff.auth.login', ['url', 'mavuti-staff']);
    }

    public function staffLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('staff')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember')))
        {

            return redirect()->intended('/mavuti-home');
        }

        return back()->withInput($request->only('email', 'remember'));
    }
}
