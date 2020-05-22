<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Staff_message;
use App\Staff_comment;

class StaffMessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,staff');
    }
    
    //Show one message
    public function show($id)
    {
        $message = Staff_message::find($id);

        $comments = Staff_comment::orderBy('created_at', 'desc')->paginate(10);

        return view('staff_message')->with(['message' => $message, 'comments' => $comments]);
    }

    //show all staff messages
    public function showAll()
    {
        $messages = Staff_message::orderBy('created_at', 'desc')->paginate(10);

        return view('staff_messages')->with('messages', $messages);
    }
}
