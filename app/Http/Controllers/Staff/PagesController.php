<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Topic;
use App\Bookstore;
use App\Comment;
use App\Staff_message;
use Auth;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:staff')->except(['login', 'register']);
    }

    //Redirect the staff member to the staff home page

    public function index()
    {
        //we want to fetch all the users, books and topics in the db and count them for the admin's dashboard

        $university = Auth::guard('staff')->user()->university;

        $users = User::Where('university', $university)->get();

        $topics = Topic::Where('university', $university)->get();
        
        $books = Bookstore::Where('university', $university)->get();
        
        $latest_books = Bookstore::Where('university', $university)->orderBy('created_at', 'desc')->get()->take(5);
        
        $latest_topics = Topic::Where('university', $university)->orderBy('created_at', 'desc')->get()->take(2);
        
        $rand_users = User::inRandomOrder()->Where("university", $university)->get()->take(5);

        return view('staff.pages.home')->with(['latest_books' => $latest_books, 'rand_users' => $rand_users, 'latest_topics' => $latest_topics, 'users' => $users, 'topics' => $topics, 'books' => $books]);
    }

    public function list_topics()
    {
        $topics = Topic::orderBy('created_at', 'desc')->paginate(10);

        return view('staff.pages.topics')->with('topics', $topics);
    }

    //return the topic the user clicked on
    public function topic($id)
    {
        $topic = Topic::find($id);

        //we also get the comments for this topic
        $comments = Comment::Where('topic_id', $id)->orderBy('created_at', 'desc')->get();

        return view('staff.pages.topic')->with(['topic' => $topic, 'comments' => $comments]);
    }

    public function contact_users()
    {
        //fetch staff messages from database and display it on the "contact user page"
        $staff_messages = Staff_message::orderBy('created_at', 'desc')->paginate(10);

        return view('contact_users')->with('staff_messages', $staff_messages);
    }
}
