<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:55',
            'surname' => 'required|string|max:55',
            'student_id' => 'required|numeric|digits:9|',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'university' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'secret_question' => 'nullable|string|max:255',
            'answer' => 'nullable|string|max:55',
            'role' => 'nullable',
            'avatar' => 'default.jpg'
        ]);

    }

    public function showRegisterStaffForm()
    {
        return view('staff.auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'student_id' => $data['student_id'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'university' => $data['university'],
            'course' => $data['course'],
            'secret_question' => 'null',
            'answer' => 'null',
            'role' => 'student',
            'avatar' => 'default.png',
        ]);
    }

    //create staff
    protected function createStaff(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'surname' => 'required|string|max:191',
            'email' => 'required|email|string|max:191|unique:staff',
            'university' => 'required|string|max:191',
            'department' => 'required|string|max:191',
            'password' => 'required|string|min:6|max:191',
            
        ]);

        $staff = Staff::create([
            'first_name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'department' => $request['department'],
            'password' => bcrypt($request['password']),
            'university' => $request['university']
        ]);

        return redirect()->intended('/mavuti-staff')->with('success', 'Your account has been created');
    }
}
