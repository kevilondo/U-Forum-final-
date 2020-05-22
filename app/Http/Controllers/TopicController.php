<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\User;
use App\Comment;
use App\Http\Controllers\SendMailController;
use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    public function list_posts()
    {
        $posts = Topic::orderBy('updated_at', 'desc')->paginate(5);
        
        return view('forum')->with(['posts' => $posts]); 
    }

    //display books posted by student doing the same course
    public function course_topics()
    {
        $posts = Topic::Where('university', auth()->user()->university)->orderBy('updated_at', 'desc')->paginate(10);
    
        return view('forum')->with(['posts' => $posts]);
    }

    public function post_topic(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required', 
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
            $path = $request->file('file')->storeAs('public/topic_files', $fileNameToStore);
        }
        else
        {
            $extension = 'none';
            $fileNameToStore = 'none';
        }

        //store in the database

        //the user who is currently logged in
        $user = auth()->user();

        $topic = new Topic;
        $topic->user_id = $user->id;
        $topic->author = $user->name. " ". $user->surname;
        $topic->course = $user->course;
        $topic->university = $user->university;
        $topic->title = $request->input('title');
        $topic->message = $request->input('message');
        $topic->file = $fileNameToStore;
        $topic->file_extension = $extension;
        $topic->save();

        //send e-mail to every user to notify them about the new post
        $email = new SendMailController;

        $users = User::Where('University', $user->university)->get();
        
        foreach ($users as $user_details)
        {
            //the user who posted this topic won't receive the email
            if ($user_details->email !== $user->email)
            {
                $name = $user_details->name;

                $user_email = $user_details->email;

                $url = "https://uforum.co.za/forum";

                $message = "There is a new post on the forum, it could be something you might be interested in, you do not want to miss out :-)";

                $topic_title = $request->input('title');

                $topic_message = $topic->message = $request->input('message');
                
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

        return redirect('/forum')->with('success', 'Your topic has been posted');
    }

    public function show_topic($id)
    {
        $topic = Topic::find($id);

        //show comments associated with the topic
        $comments = Comment::Where('topic_id', $id)->orderBy('updated_at', 'desc')->paginate(10);
    
        return view('comment')->with(['topic' => $topic, 'comments' => $comments]);
    }

    public function delete_topic($id)
    {
        $topic = Topic::find($id);

        if ($topic->file !== 'none')
        {
            unlink(public_path('storage/topic_files/'.$topic->file));
            //Storage::disk('public/topic_files')->delete($topic->file);
        }
        
        $topic->delete();

        return redirect('/forum')->with('success', 'Your topic has been deleted');
    }
}
