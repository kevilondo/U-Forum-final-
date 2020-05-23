<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookstore;
use App\User;
use App\Events\SendEmailEvent;
use Carbon\Carbon;

class BookstoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Display books stored in the database
    public function list_books()
    {
        $user = auth()->user();

        $books = Bookstore::where('university', $user->university)->orderBy('updated_at', 'desc')->paginate(10);
        
        return view('bookstore')->with(['books' => $books]); 
    }

    //display books posted by student doing the same course
    public function course_books()
    {
        $user = auth()->user();

        $books = Bookstore::Where('university', $user->university)->where('course', $user->course)->orderBy('updated_at', 'desc')->paginate(10);

        return view('bookstore')->with(['books' => $books]);
    }

    public function post_book(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required', 
            'file' => 'file|nullable|max:10000',
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
            $path = $request->file('file')->storeAs('public/books', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'no_image.png';
        }

        //store in the database

        //the user who is currently logged in
        $user = auth()->user();

        $book = new Bookstore;
        $book->user_id = $user->id;
        $book->course = $user->course;
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->cover = $fileNameToStore;
        $book->university = $user->university;
        $book->save();

        //send e-mail to every user to notify them about the new post
        $email = new SendMailController;

        $users = User::Where('university', $user->university)->get();
        
        foreach ($users as $user_details)
        {
            //The user who posted the offer won't receive the e-mail
            if ($user_details->email !== $user->email)
            {
                $name = $user_details->name;

                $user_email = $user_details->email;
                
                $message = "There is a new offer on the forum, it might be something you are looking for or a potentiel client ;-)";

                $url = "https://uforum.co.za/bookstore";

                $topic_title = $request->input('title');

                $topic_message = $request->input('description');

                $data = [

                    'user_email' => $user_email,
                    
                    'name' => $name,

                    'message' => $message,

                    'topic_title' => $topic_title,

                    'topic_message' => $topic_message,

                    'url' => $url,
                ];

                event(new SendEmailEvent($data));
            }
        }

        return redirect('/bookstore')->with('success', 'Your item has been posted');
    }

    public function delete($id)
    {
        $item = Bookstore::find($id);

        $item->delete();

        return redirect('/bookstore')->with('success', 'Your item has been deleted');
    }
}
