<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Staff_message;
use Auth;

class StaffController extends Controller
{
    //Post a message for users
    public function contact_users(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'file' => 'nullable|file|max:10000'
        ]);

        //Handle file upload
        if ($request->hasFile('file'))
        {
            //get filename with extension
            $filenameWithExt = $request->file('file')->getClientOriginalName();

            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //get just ext
            $extension = $request->file('file')->getClientOriginalExtension();

            //filename to store
            $fileNameToStore = $filename. '_'. time(). '.'. $extension;

            //Upload image
            $path = $request->file('file')->storeAs('public/staff_files', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = null;
        }

        //store in the database

        $staff_message = new Staff_message;

        $staff_message->message = $request->input('message');
        $staff_message->file = $fileNameToStore;
        $staff_message->staff_id = Auth::guard('staff')->user()->id;
        $staff_message->save();

        return redirect('/contact_users')->with('success', 'The message has been posted');
    }

    public function delete_message($id)
    {
        $staff_message = Staff_message::find($id);
    
        if ($staff_message->file !== 'none')
        {
            unlink(public_path('storage/staff_files/'.$staff_message->file));
                
        }
            
        $staff_message->delete();
    
        return redirect('/contact_users')->with('success', 'The message has been deleted');
    }
}
