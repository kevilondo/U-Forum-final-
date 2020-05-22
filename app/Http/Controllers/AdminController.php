<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

use App\User;

use App\Events\SendEmailEvent;

use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public function list_articles()
    {
        $articles = Article::orderBy('updated_at', 'desc')->paginate(2);

        return view('articles')->with(['articles' => $articles]);
    }

    public function publish_article($id)
    {
        $article = Article::find($id);

        $article->accepted = '1';

        $article->save();

        //send e-mail to every user to notify them about the new post
        $email = new SendMailController;

        $users = User::Where('role', 'student')->get();
        
        foreach ($users as $user)
        {
            $name = $user->name;

            if($user->email !== null)
            {
                $user_email = $user->email;
            }
            else
            {
                $user_email = $user->student_id. "@student.uj.ac.za";
            }
            
            $message = "A new article has been published on the forum, click on the button below to read the latest articles";

            $url = "https://uforum.co.za/";

            $data = [

                'user_email' => $user_email,
                
                'name' => $name,

                'message' => $message,

                'url' => $url,
            ];

            event(new SendEmailEvent($data));

            return redirect('/articles')->with('success', 'The article has been published');
        }
    }

    public function reject_article($id)
    {
        $user = User::find($id);

        $user_email = $user->email;

        $name = $user->name. " ". $user->surname;

        $message = "We are sorry to inform you that you're article was rejected. You can still improve and send it to us as soon as possible, we believe in your capacities and we will be glad to read and publish one of articles :-)";

            $url = "https://uforum.co.za/";

            $data = [

                'user_email' => $user_email,
                
                'name' => $name,

                'message' => $message,

                'url' => $url,
            ];

            event(new SendEmailEvent($data));

            return redirect('/articles')->with('success', 'An e-mail has been sent to the user');
    }

    public function delete_article($id)
    {
        $article = Article::find($id);

        $article->delete();

        return redirect('/articles')->with('success', 'The article has been deleted');
    }

    public function contact_users(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        $users = User::Where('role', 'student')->get();

        foreach ($users as $user)
        {
            $name = $user->name;

            if($user->email !== null)
            {
                $user_email = $user->email;
            }
            else
            {
                $user_email = $user->student_id. "@student.uj.ac.za";
            }
            
            $message = $request->input('message');

            $url = "https://uforum.co.za/";

            $data = [

                'user_email' => $user_email,
                
                'name' => $name,

                'message' => $message,

                'url' => $url,
            ];

            event(new SendEmailEvent($data));
        }

        return redirect('/contact_users')->with('success', 'An e-mail has been sent to all users');

    }
}
