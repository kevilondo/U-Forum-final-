<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Auth;
use App\User;
use App\Http\Controllers\SendMailController;
use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    //Upload videos
    public function upload_videos(Request $request)
    {
        //validate
        $this->validate($request, [
            'title' => 'required',
            'video' => 'required|mimes:mp4,mov,ogg,qt,flv,avi,mov|max:20000'
        ]);

        //Handle file upload
        if ($request->hasFile('video'))
        {
            //get filename with extension
            $filenameWithExt = $request->file('video')->getClientOriginalName();

            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            //get just ext
            $extension = $request->file('video')->getClientOriginalExtension();

            //filename to store
            $fileNameToStore = $filename. '_'. time(). '.'. $extension;

            //Upload image
            $path = $request->file('video')->storeAs('public/videos', $fileNameToStore);
        }
        else
        {
            return redirect()->back()->with('error', 'File not supported');
        }

        //store in database

        $video = new Video;
        $user = auth()->user();

        $video->title = $request->input('title');
        $video->file = $fileNameToStore;
        $video->user_id = $user->id;
        $video->student_course = $user->course;
        $video->university = $user->university;
        $video->save();

        //send e-mail to every user to notify them about the new post
        $email = new SendMailController;

        $user_emails = User::Where('university', $user->university)->Where('course', $user->course)->get();
        
        foreach ($user_emails as $user_email)
        {
            //if the recipient's email is different from the sender's email
            //we don't want to the user to send an email to himself
            if ($user_email->email !== $user->email)
            {
                $name = $user_email->name;

                $email = $user_email->email;

                $url = url('/videos');

                $message = $user->name. " ". $user->surname. " uploaded a new video that might be useful to you, you do not want to miss out :-)";

                $video_title = $request->input('title');
                
                $data = [

                    'user_email' => $user_email,
                    
                    'name' => $name,

                    'message' => $message,

                    'topic_title' => $video_title,

                    'topic_message' => $message,

                    'url' => $url,
                ];

                event(new SendEmailEvent($data));
            }
        }


        return redirect('/videos')->with('success', 'Your video has been uploaded');
    }

    public function show_videos()
    {
        $user = auth()->user();

        $videos = Video::Where('student_course', $user->course)->Where('university', $user->university)->orderBy('created_at', 'desc')->paginate(10);

        return view('videos')->with(['videos' => $videos]);
    }
}
