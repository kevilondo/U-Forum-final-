<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inbox;
use App\Chat_list;
use App\User;
use DB;
use App\Events\SendEmailEvent;
use Illuminate\Support\Facades\Storage;

class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Chat list
    public function inbox_page()
    {
        $chats = Chat_list::Where(function($query) {
            $query->Where('first_user_id', auth()->user()->id)
                ->orWhere('second_user_id', auth()->user()->id);
        })->orderBy('created_at', 'desc')->get();

        /**Empty arrays that contain respectively the users chatting with the user who is logged in, the conversations,
         messages not yet opened and the users who sent a message to the user */

        $users = [];
        $conversations = [];
        $unread_chats = [];
        $unread_users = [];

         /** if the user participates to conversations we get the users who are chatting with him */

        if (count($chats) > 0)
        {
            foreach ($chats as $chat)
            {
                 
                if ($chat->first_user_id !== auth()->user()->id)
                {
 
                    $users[] = User::where(function($query) use ($chat) {
                        $query->where('id', $chat->first_user_id);
                    })
                    ->get();
                }
                else
                {
                    $users[] = User::where(function($query) use ($chat) {
                        $query->where('id', $chat->second_user_id);
                    })
                    ->get();
                }
 
            }

            //here we fetch the conversations that haven't been opened yet, and we do it based on the people interacting with the active user
            foreach($users as $user)
            {
                $unread_chats[] = Inbox::where('id_recipient', auth()->user()->id)->where('seen', 0)->get();
            }

            /**if we find conversations in the database, we go through all of them and we add the sender of each convo in an array */

            if (!$unread_chats[0]->isEmpty())
            {
                $i = 0;
                foreach ($unread_chats as $unread_chat)
                { 
                    if (isset($unread_chat[$i]))
                    {
                        if (!in_array($unread_chat[$i]->id_sender, $unread_users))
                        {
                            $unread_users[] = $unread_chat[$i]->id_sender;
                            $i++;
                        }
                        
                    }
                }
            }
            else
            {
                $unread_chat = null;
                $unread_users[] = null;
            }
        }
        else
        {
            $chats = null;
        }

        //dd($unread_users);

        return view('inbox')->with(['users' => $users, 'unread_chats' => $unread_chats, 'chats' => $chats, 'unread_users' => $unread_users]);
    }

    public function chat($id)
    {
        $user = User::find($id);

        $recipient_id = auth()->user()->id;


        //get messages from database
        $chats = Inbox::Where(function($query) {
            $query->Where('id_sender', auth()->user()->id)
                ->orWhere('id_recipient', auth()->user()->id);
        })
       ->Where(function ($query) use ($id) {
            $query->Where('id_sender', $id)
                ->orWhere('id_recipient', $id);
        })
       ->get();

       /* an array that contains all the file extensions that will be used in the view 
       if the file's extension is jpg, jpeg, gif, the image will be displayed, but if the file is not an image
       we'll only display a link to download or open the file **/

       $image_extensions = ['jpg', 'jpeg', 'gif', 'png'];

        //mark a message as read once the chat is opened

        $message = Inbox::Where('id_sender', $id)->Where('id_recipient', $recipient_id)->update(array('seen' => '1'));

        return view('chat')->with(['user' => $user, 'chats' => $chats, 'image_extensions' => $image_extensions]);
    }

    public function send_message(Request $request, $id)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        /*we check whether the conversation already exists in the database or not, if it exists, 
        then we'll just update the existing one istead of creating a new convo */

        $user = User::find($id);

        $chat_query = Chat_list::Where(function($query) {
             $query->Where('first_user_id', auth()->user()->id)
                 ->orWhere('second_user_id', auth()->user()->id);
         })
        ->Where(function ($query) use ($id) {
             $query->Where('first_user_id', $id)
                 ->orWhere('second_user_id', $id);
         })
        ->first();

        if (!$chat_query)
        {   
            $chat = new Chat_list;
            $chat->first_user_id = auth()->user()->id;
            $chat->second_user_id = $user->id;
            //$chat->seen = 0;
            $chat->save();
        }
        else
        {
            $chat = Chat_list::find($chat_query->id);
            $chat->first_user_id = auth()->user()->id;
            $chat->second_user_id = $user->id;
            //$chat->seen = 0;
            $chat->created_at = date('Y-m-d H:i:s');
            $chat->save();
        }
        

        //Add messages in the database, in the chat_messages table

        $message = new Inbox;
        $message->id_sender = auth()->user()->id;
        $message->id_recipient = $user->id;
        $message->message = $request->message;
        $message->seen = 0;

        $message->save();

        //send e-mail to every user to notify them about the new post
                
        $name = $user->name;

        if($user->email !== null)
        {
            $user_email = $user->email;
        }
        else
        {
            $user_email = $user->student_id. "@student.uj.ac.za";
        }
        
        $message = "You have new messages, check your DM";

        $url = "https://uforum.co.za/inbox";

        $data = [

            'user_email' => $user_email,
            
            'name' => $name,

            'message' => $message,

            'url' => $url,
        ];

        event(new SendEmailEvent($data));

        return redirect('/chat/'. $id);
    }

    public function messagesCount()
    {
        if (auth()->user())
        {
            $messages = Inbox::Where('id_recipient', auth()->user()->id)->Where('seen', '0')->get();

            $messagesCount = count($messages);

            return $messagesCount;
        }
    }

    //send multiple files
    public function send_files(Request $request, $id)
    {
        
           // dd($request->files);
        //Handle file upload
        if ($request->hasFile('files'))
        {
            for ($i=0; $i < count($request->file('files')); $i++)
            {
                
                //dd($file);
                //get filename with extension
                $filenameWithExt = $request->file('files')[$i]->getClientOriginalName();

                //get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

                //get just ext
                $extension = $request->file('files')[$i]->getClientOriginalExtension();

                //filename to store
                $fileNameToStore = $filename. '_'. time(). '.'. $extension;
                
                //Upload image
                $path = $request->file('files')[$i]->storeAs('public/inbox', $fileNameToStore);
                
                $inbox = new Inbox;

                $inbox->id_sender = auth()->user()->id;
                
                $inbox->id_recipient = $id;

                $inbox->file = $fileNameToStore;

                $inbox->seen = 0;

                $inbox->file_extension = $extension;

                $inbox->save();
                
            }

                $user = User::find($id);

                $name = $user->name;

                $user_email = $user->email;

                $message = "You have new messages, check your DM";

                $url = "http://127.0.0.1:8100/inbox";

                $data = [

                    'user_email' => $user_email,
                    
                    'name' => $name,
        
                    'message' => $message,
        
                    'url' => $url,

                    'topic_message' => $message,
                ];
        
                event(new SendEmailEvent($data));

            return redirect('/chat/'. $id. '/#message');
        }
    }
}
