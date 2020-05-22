<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use App\User;

use App\Bookstore;

use App\Topic;

use App\Staff_message;

use Auth;

class PagesController extends Controller
{
    //
    public function index()
    {
        //fetch articles that have been published 
        $articles = Article::Where('accepted', '1')->orderBy('updated_at', 'desc')->paginate(2); 

        //we want to fetch all the users, books and topics in the db and count them for the admin's dashboard

        $users = User::get();

        $topics = Topic::get();

        $books = Bookstore::get();

        $staff_messages = Staff_message::orderBy('created_at', 'desc')->get()->take(7);

        $latest_books = Bookstore::orderBy('created_at', 'desc')->get()->take(5);

        $latest_topics = Topic::orderBy('created_at', 'desc')->get()->take(2);

        //display all the other users if the user is not logged in, otherwise we will only display the users in the same university
        if (!Auth::guest())
        {
            $rand_users = User::inRandomOrder()->Where("university", auth()->user()->university)->get()->take(5);
        }
        else
        {
            $rand_users = User::inRandomOrder()->get()->take(5);
        }

        return view('index')->with(['latest_books' => $latest_books, 'staff_messages' => $staff_messages, 'rand_users' => $rand_users, 'latest_topics' => $latest_topics, 'users' => $users, 'topics' => $topics, 'books' => $books]);
    }

    public function write_article()
    {
        return view('new_article');
    }

    public function profile()
    {
        $user = auth()->user();

        return view('profile')->with(['user' => $user]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function update()
    {
        return view('update');
    }

    public function about_us()
    {
        return view('about_us');
    }
}
