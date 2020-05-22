<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//use Illuminate\Hashing\BcryptHasher;
use Hash;

class UsersController extends Controller
{

    //Change profile picture

    public function change_avatar(Request $request)
    {
        $this->validate($request, [

            'new_avatar' => 'image|required|max:10000',
        ]);

        //user id
        $id = auth()->user()->id;

        //Handle file upload
            //get filename with extension
            $filenameWithExt = $request->file('new_avatar')->getClientOriginalName();

            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //get just ext
            $extension = $request->file('new_avatar')->getClientOriginalExtension();

            //filename to store
            $fileNameToStore = $id.'.'. $extension;

            //Upload image
            $path = $request->file('new_avatar')->storeAs('public/avatar', $fileNameToStore);

        //store in the database
        
        $user = User::find($id);
        $user->avatar = $fileNameToStore;
        $user->save();
        
        return redirect('/profile');
    }

    public function change_password(Request $request)
    {
        //user id
        $id = auth()->user()->id;

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|string|min:6', 
            'new_password_conf' => 'required',
        ]);
        
        if ($request->input('new_password') == $request->input('new_password_conf'))
        {
            $passwordToCheck = $request->input('old_password');

            $user = User::find($id);

            if (Hash::check($passwordToCheck, $user->password))
            {
                $user->password = bcrypt($request->input('new_password_conf'));
            
            
                $user->save();

                return redirect('/profile')->with('success', 'Your password has been updated');
            }
            else
            {
                return redirect('/profile')->with('error', 'Make sure your old password is correct');
            }
        }
        else
        {
            return redirect('/profile')->with('error', 'Confirm your new password and make sure your old password is correct');
        }
    }

    public function delete_account(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        $user_id = auth()->user()->id;

        $user = User::find($user_id);

        $passwordToCheck = $request->input('password');

        if (Hash::check($passwordToCheck, $user->password))
        {

            $user->delete();

            return redirect('/')->with('success', 'Your account has been deleted');
        }
        else
        {
            return redirect('/profile')->with('error', 'Your password is incorrect');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);

        $student_id = $request->input('student_id');
        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        $user = User::Where('student_id', $student_id)->first();
        
        if ($user)
        {
            $user->email = $email;
            $user->password = $password;
            $user->save();
        }
        else
        {
            return redirect('/update')->with('error', 'This student number is incorrect');
        }

        return redirect('/login')->with('success', 'Your account has been updated');
    }
}
