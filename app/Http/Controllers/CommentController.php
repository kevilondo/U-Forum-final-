<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Controllers\NotifController;
use App\Topic;
use App\Staff_comment;
use App\Staff_message;
use Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,staff');
    }
    
    //
    public function post_comment(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required', 
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
            $path = $request->file('file')->storeAs('public/comment_files', $fileNameToStore);
        }
        else
        {
            $extension = 'none';
            $fileNameToStore = 'none';
        }

        //store in the database

        $comment = new Comment;
        $comment->topic_id = $id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->input('comment');
        $comment->file = $fileNameToStore;
        $comment->file_extension = $extension;
        $comment->save();

        //send notification after commenting on the post

        $sender = auth()->user()->id;

        $post = Topic::find($id);
        
        $recipients = array();

        //We wont add the author of the post when he comments on his own post
        if ($post->user_id !== $sender)
        {
            array_push($recipients, $post->user_id);
        }

        $topic = Comment::Where('topic_id', $id)->get();

        foreach($topic as $user)
        {
            //if the user is already added as a recipient, he won't be added, this step will be skipped
            if (!in_array($user->user_id, $recipients) && $user->user_id !== $sender)
            {
                
                array_push($recipients, $user->user_id);

            }
        }

        $notif = new NotifController;

        $notif->send_notification($recipients, $sender, $id);

        return redirect('/comment/'. $id)->with(['success' => 'Your comment has been posted']);
    }

    public function delete_comment($id, $topic)
    {
        $comment = Comment::find($id);

        if ($comment->file !== 'none')
        {
            unlink(public_path('storage/comment_files/'.$comment->file));
            //Storage::disk('public/topic_files')->delete($topic->file);
        }

        $comment->delete();

        return redirect('/comment/'. $topic)->with(['success' => 'Your comment has been deleted']);
    }

    //post a comment on a staff message
    public function staff_message_comment(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        
        
        $staff_comment = new Staff_comment;
        $staff_comment->message_id = $id;
        $staff_comment->comment = $request->input('comment');

        if (Auth::guard('staff')->check())
        {
            $staff_comment->user_id = null;
            $staff_comment->staff_id = Auth::guard('staff')->user()->id;
        }
        else
        {
            $staff_comment->user_id = auth()->user()->id;
            $staff_comment->staff_id = null;
        }

        $staff_comment->save();

        //send notification after commenting on the post

        $sender = auth()->user()->id;

        $post = Staff_message::find($id);
        
        $recipients_staff = array();
        
        $recipients_users = array();

        //We wont add the author of the post when he comments on his own post
        if (Auth::guard('staff')->check())
        {
            if ($post->staff_id !== $sender)
            {
                array_push($recipients_staff, $post->staff_id);
            }
        }
        else
        {
            array_push($recipients_staff, $post->staff_id);
        }

        $users = Staff_comment::Where('message_id', $id)->get();

        foreach($users as $user)
        {
            if (isset($user->user_id))
            {
                //if the user is already added as a recipient, he won't be added, this step will be skipped
                if (!in_array($user->user_id, $recipients_users) && $user->user_id !== $sender)
                {
                    
                    array_push($recipients_users, $user->user_id);

                }
            }
        }
        
        //dd($recipients_users);

        $notif = new NotifController;

        $notif->send_notif_staff($recipients_staff, $recipients_users, $sender, $id);

        return redirect('/staff_message/'. $id)->with(['success' => 'Your comment has been posted']);
    }


    public function delete_staff_comment($comment_id, $message_id)
    {
        $comment = Staff_comment::find($comment_id);

        $comment->delete();

        return redirect('/staff_message/'. $message_id)->with(['success' => 'Your comment has been deleted']);
    }
    
}
