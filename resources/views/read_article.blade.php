@extends('layout.app')

@section('content')

    <div class="container content">
        <img class="rounded-circle" src="/storage/avatar/{{$user->avatar}}" height="100px" width="100px"> <h2> {{$article->author}} </h2>
        <p> {{$article->author_varsity}} </p>
        
        <h1> {{$article->title}} </h1>
        <p> {{$article->date_time}} </p><br />
        
        <p>
            {!!$article->content!!}
        </p>
    </div> <br /> <br />
    @if (auth()->user()->role == 'admin')
        @if ($article->accepted == '0')
            <div class="article-options">
                <a href="/article_accepted/{{$article->id}}">Publish this article</a>
                <a href="/article_delete/{{$article->id}}">Delete this article</a>
                <a href="/article_rejected/{{$article->user->id}}">Reject this article</a>
            </div>
        @else
            <div class="article-options">
                <a href="/article_delete/{{$article->id}}">Delete this article</a>
            </div>
        @endif
    @endif
@endsection