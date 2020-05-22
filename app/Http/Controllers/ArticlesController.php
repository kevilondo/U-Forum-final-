<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\User;

class ArticlesController extends Controller
{
    //

    public function publish_article(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'article' => 'required',
        ]);

        $article = new Article;
        $article->user_id = auth()->user()->id;
        $article->author = auth()->user()->name. " ". auth()->user()->surname;
        $article->author_email = auth()->user()->email;
        $article->author_varsity = auth()->user()->university;
        $article->author_course = auth()->user()->course;
        $article->title = $request->title;
        $article->content = $request->article;
        $article->date_time = date('d-M-Y');
        $article->accepted = 0;

        $article->save();

        return view('new_article')->with('success', 'Your article has been posted, you will be notified as soon as it is approved by our team');
    }

    public function read_article($id)
    {
        $article = Article::find($id);

        $user = User::find($article->user_id);

        return view('read_article')->with(['article' => $article, 'user' => $user]);
    }
}


