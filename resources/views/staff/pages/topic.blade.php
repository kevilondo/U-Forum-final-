@extends('layout.app')

@section('content')
    <div class="content">
        <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
            <div class="uk-card-header">
                @if ($topic->user->id !== auth()->user()->id)
                    <a href="/chat/{{$topic->user->id}}">
                        <img class="rounded-circle" src="/storage/avatar/{{$topic->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$topic->author}} </b>
                    </a>
                @else
                    <img class="rounded-circle" src="/storage/avatar/{{$topic->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$topic->author}} </b>
                @endif
            </div>

            <div class="uk-card-title">
                <b> {{$topic->title}} </b>
            </div> <br>

            <div class="uk-card-body">
                {{$topic->message}}
            </div>

            <div>
                @if ($topic->file_extension !== 'none')
                                    
                    @if ($topic->file_extension == 'jpg' || $topic->file_extension == 'jpeg' || $topic->file_extension == 'png' || $topic->file_extension == 'gif')
                        <a href="/storage/topic_files/{{$topic->file}}"> <img src="/storage/topic_files/{{$topic->file}}" height="50%" width="100%"> </a>
                    @else
                        <a href="/storage/topic_files/{{$topic->file}}"> Open the file </a>
                    @endif
                @endif
            </div>

            <div class="uk-card-footer"> <br />
                <b> {{$topic->date_time}} </b>
            </div>
            
            @if ($topic->user->id == auth()->user()->id)
            
                <div>
                    <a href="/delete_topic/{{$topic->id}}"> <b> Delete this topic </b> </a>
                </div>
            @endif
        </div> <br>

        @foreach ($comments as $comment)
            <div class="container uk-card uk-card-small uk-card-default">
                @if ($comment->user->id !== auth()->user()->id)
                    <a href="/chat/{{$comment->user->id}}">
                        <h4 class="uk-card-title"> <img class="rounded-circle" src="/storage/avatar/{{$comment->user->avatar}}" height="50px" width="50px"> {{$comment->user->name. " ". $comment->user->surname}}</h4>
                    </a>
                @else 
                    <h4 class="uk-card-title"> <img class="rounded-circle" src="/storage/avatar/{{$comment->user->avatar}}" height="50px" width="50px"> {{$comment->user->name. " ". $comment->user->surname}}</h4>
                @endif
                <p>{{$comment->comment}}</p>

                @if ($comment->file_extension !== 'none')
                                    
                    @if ($comment->file_extension == 'jpg' || $comment->file_extension == 'jpeg' || $comment->file_extension == 'png' || $comment->file_extension == 'gif')
                        <a href="/storage/comment_files/{{$comment->file}}"> <img src="/storage/comment_files/{{$comment->file}}" height="50%" width="100%"> </a>
                    @else
                        <a href="/storage/comment_files/{{$comment->file}}"> Open the file </a>
                    @endif
                @endif

                <div class="uk-card-footer">
                    <small> {{$comment->date_time}} </small>
                </div>

                <div>
                    @if ($comment->user->id == auth()->user()->id)
                        <small style="margin-right: auto"> <a href="/delete_comment/{{$comment->id}}/{{$topic->id}}">Delete this comment</a> </small>
                    @endif
                </div>
                
            </div><br>
        @endforeach

    </div>
@endsection