@extends('layout.app')

@section('content')
    @if (count($articles) > 0)
        @foreach ($articles as $article)
            <div class="mt-3 content uk-card uk-card-default uk-card-small uk-card-hover">
                    <div class="uk-card-title">
                        <p>Title: {{$article->title}}  </p>
                    </div>
                    
                    <div class="uk-card-body">
                        <p>Author: <img class="rounded-circle" src="/storage/avatar/{{$article->user->avatar}}" height="60px" width="60px"> {{$article->author}} </p> 
                        <p>From: {{$article->author_varsity}}</p>
                    </div>
                    
                    <div class="uk-card-footer">
                        <p> {{$article->date_time}} </p>
                        <a href='/read_article/{{$article->id}}'> <p>Read more</p> </a>

                        @if ($article->accepted == '0')
                            <small>Not accepted</small>
                        @endif
                    </div>
            </div> <br />
        @endforeach

        <div class="content"> {{$articles->links()}} </div>
    @endif
@endsection