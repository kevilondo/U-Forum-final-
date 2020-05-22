@extends('layout.app')

@section('content')
    <div class="content">
        <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
            <div class="uk-card-header">
                <h3> {{$message->staff->first_name. " ". $message->staff->surname}} </h3>
            </div>

            <div class="uk-card-body">
                {{$message->message}}
            </div>

            @if ($message->file !== null || $message->file !== 'none')
                <div class="container">
                    <p> <a href="/storage/staff_files/{{$message->file}}">Click here to open file</a> </p>
                </div>
            @endif

            <div class="uk-card-footer">
                <b> {{date('d-M-Y H:i', strtotime($message->created_at))}} </b> <br>
            </div>
        </div>

        <form action="/staff_message/{{$message->id}}" method="post">
            {{ csrf_field() }}
            <textarea name="comment" cols="40" rows="5"></textarea>
            <input type="submit" class="button" value="Comment">
        </form>
    </div>

    <div class="content">
        @if (count($comments) > 0)
            @foreach ($comments as $comment)
                <div class="container uk-card uk-card-default uk-card-small uk-card-hover">
                    @if (isset($comment->user->id))
                        @if ($comment->user->id !== auth()->user()->id && !Auth::guard('staff')->check())
                            <a href="/chat/{{$comment->user->id}}">
                                <h4 class="uk-card-title"> {{$comment->user->name. " ". $comment->user->surname}} </h4>
                            </a>
                        @else
                            <h4 class="uk-card-title"> {{$comment->user->name. " ". $comment->user->surname}} </h4>
                        @endif
                        <p> {{$comment->comment}} </p>

                        <div class="uk-card-footer">
                            <small> {{date('d-M-Y H:i', strtotime($comment->created_at))}} </small>
                        </div>

                        <div>
                            @if (Auth::guard('web')->check() && $comment->user->id == auth()->user()->id)
                                <small style="margin-right: auto"> <a href="/delete_staff_comment/{{$comment->id}}/{{$message->id}}">Delete this comment</a> </small>
                            @endif
                        </div>
                    @else
                        <h4 class="uk-card-title"> {{$comment->staff->first_name. " ". $comment->staff->surname}} <span style="font-size: 12px">(Staff)</span> </h4>

                        <p> {{$comment->comment}} </p>

                        <div class="uk-card-footer">
                            <small> {{date('d-M-Y H:i', strtotime($comment->created_at))}} </small>
                        </div>

                        <div>
                            @if (Auth::guard('staff')->check() && $comment->staff->id == auth()->user()->id)
                                <small style="margin-right: auto"> <a href="/delete_staff_comment/{{$comment->id}}/{{$message->id}}">Delete this comment</a> </small>
                            @endif
                        </div>
                    @endif
                </div> <br>
            @endforeach
        @endif
    </div>
@endsection