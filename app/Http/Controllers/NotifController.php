<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notif;
use App\User;
use App\Events\SendEmailEvent;
use Auth;

class NotifController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web,staff');
    }
    
    //send notification to users

    public function send_notification($recipients, $sender, $id)
    {
        foreach($recipients as $recipient)
        {
            
            $notif = new Notif;
            $notif->user_id = $sender;
            $notif->staff_id = null;
            $notif->id_recipient = $recipient;
            $notif->topic_id = $id;
            $notif->message = "commented on a post";
            $notif->recipient_role = "user";
            $notif->notif_type = "user_notif";
            $notif->seen = 0;
            $notif->save();
            

            //send e-mail to every user to notify them about the new post
            $email = new SendMailController;

            $user = User::find($recipient);
            
            $name = $user->name;

            if($user->email !== null)
            {
                $user_email = $user->email;
            }
            else
            {
                $user_email = $user->student_id. "@student.uj.ac.za";
            }
            
            $message = "You have new notifications";

            $url = "https://uforum.co.za/notifications";

            $data = [

                'user_email' => $user_email,
                
                'name' => $name,

                'message' => $message,

                'url' => $url,
            ];

            event(new SendEmailEvent($data));
        }
    }

    public function list_notifications()
    {
        $user_id = auth()->user()->id;

        /*since the staff and user might have the same id, we differentiate them with the recipient role
        to avoid any confusion, now we're sure that it will only fetch the notification of the user who's logged in */
        if (Auth::guard('web')->check())
        {
            $notifs = Notif::Where('id_recipient', $user_id)->Where('recipient_role', 'user')->orderBy('created_at', 'desc')->take(50)->get();
        }
        else
        {
            $notifs = Notif::Where('id_recipient', $user_id)->Where('recipient_role', 'staff')->orderBy('created_at', 'desc')->take(50)->get();
        }

        return view('notifications')->with(['notifs' => $notifs]);
    }

    public function read_notification($post_id, $notif_id)
    {
        $user_id = auth()->user()->id;

        //fetch the notification from the db to see whether it's a staff_message or user_notif
        $notification = Notif::find($notif_id);

        if ($notification->notif_type == "staff_message")
        {
            if (Auth::guard('web')->check())
            {
                $notif = Notif::Where('staff_message_id', $post_id)->Where('id_recipient', $user_id)->Where('recipient_role', 'user')->update(array('seen' => '1'));
            }
            else
            {
                $notif = Notif::Where('staff_message_id', $post_id)->Where('id_recipient', $user_id)->Where('recipient_role', 'staff')->update(array('seen' => '1'));
            }

            return redirect('/staff_message/'. $post_id);
        }
        else
        {
            if (Auth::guard('web')->check())
            {
                $notif = Notif::Where('topic_id', $post_id)->Where('id_recipient', $user_id)->Where('recipient_role', 'user')->update(array('seen' => '1'));
            }
            else
            {
                $notif = Notif::Where('topic_id', $post_id)->Where('id_recipient', $user_id)->Where('recipient_role', 'user')->update(array('seen' => '1'));
            }

            return redirect('/comment/'. $post_id);
        }

        
    }

    public function notifCount()
    {
        if (!Auth::guest())
        {
            if (Auth::guard('web')->check())
            {
                $notif = Notif::Where('id_recipient', auth()->user()->id)->Where('seen', '0')->Where('recipient_role', 'user')->get();
            }

            if (Auth::guard('staff')->check())
            {
                $notif = Notif::Where('id_recipient', auth()->user()->id)->Where('seen', '0')->Where('recipient_role', 'staff')->get();
            }

            $notifCount = count($notif);

            return $notifCount;
        }
    }

    public function send_notif_staff($recipients_staff, $recipients_users, $sender, $id)
    {
        foreach($recipients_staff as $staff)
        {
            
            $notif = new Notif;
            if(Auth::guard('staff')->check())
            {
                $notif->user_id = null;
                $notif->staff_id = $sender;
            }
            else
            {
                $notif->user_id = $sender;
                $notif->staff_id = null;
            }
            $notif->id_recipient = $staff;
            $notif->topic_id = null;
            $notif->staff_message_id = $id;
            $notif->message = "commented on a staff message";
            $notif->recipient_role = "staff";
            $notif->notif_type = "staff_message";
            $notif->seen = 0;
            $notif->save();
    
        }

        foreach ($recipients_users as $users)
        {
            $notif = new Notif;
            if(Auth::guard('web')->check())
            {
                $notif->user_id = $sender;
                $notif->staff_id = null;
            }
            else
            {
                $notif->user_id = null;
                $notif->staff_id = $sender;
            }
            $notif->id_recipient = $users;
            $notif->topic_id = null;
            $notif->staff_message_id = $id;
            $notif->message = "commented on a staff message";
            $notif->recipient_role = "user";
            $notif->notif_type = "staff_message";
            $notif->seen = 0;
            $notif->save();
        }
    }
}
