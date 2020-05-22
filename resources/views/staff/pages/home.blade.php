@extends('layout.app')

@section('content')

@if (Auth::guard('staff'))

    <div class="container">
        <div class="dashboard col-md-12 row">
            <div class="uk-card col-md-3 ml-2 uk-card-default uk-card-hover uk-card-small uk-card-body">
                <h2 class="uk-card-title">Number of users</h2>
                <h4>{{count($users)}}</h4>
            </div> <br>

            <div class="uk-card col-md-3 ml-2 uk-card-default uk-card-hover uk-card-small uk-card-body">
                <h2 class="uk-card-title">Number of topics</h2>
                <h4>{{count($topics)}}</h4>
            </div> <br>

            <div class="uk-card col-md-3 ml-2 mt-2 uk-card-default uk-card-hover uk-card-small uk-card-body">
                <h2 class="uk-card-title">Number of items in the bookstore</h2>
                <h4>{{count($books)}}</h4>
            </div><br>
        </div>
    </div>
@else

@endif


<div class="container-fluid mt-5">
    <div class="row">

        <div class="col-md-4 mt-5">
            <h3 class="latest">-Community-</h3>

            <div class="uk-card uk-card-default uk-card-hover mt-3">
                @foreach ($rand_users as $rand_user)
                    <p> <img src="/storage/avatar/{{$rand_user->avatar}}" height="70px" width="70px" class="rounded-circle"> <b> {{$rand_user->name. " ". $rand_user->surname}} </b> </p>
                @endforeach
            </div>
                
        </div>

        @if (count($latest_books) > 0)
            <div class="col-md-4">

                <div class="content mt-5">
                    <h3 class="latest">-Latest items in the bookstore-</h3>
                </div>

                @foreach ($latest_books as $book)

                    <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
                        <div class="uk-card-header">
                                <img class="rounded-circle" src="/storage/avatar/{{$book->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$book->user->name. " ". $book->user->surname}} </b>
                        </div><br>

                        <div class="uk-card-title">
                            <b> {{$book->title}} </b>
                        </div> <br>

                        <div class="uk-card-body">
                            {{$book->message}}
                        </div>

                        <div>
                            <a href="/storage/books/{{$book->cover}}"> <img src="/storage/books/{{$book->cover}}" height="100%" width="100%"> </a>
                        </div>

                        <div class="uk-card-footer"> <br />
                            <b> <b> {{date('d-M-Y H:i', strtotime($book->created_at))}} </b> </b>
                        </div>

                    </div>
                @endforeach

            </div>
        @endif
            
        <div class="col-md-4">
            <div class="content mt-5">
                <h3 class="latest">-Latest topics-</h3>
            </div> 

            @foreach ($latest_topics as $latest_topic)
                <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
                    <div class="uk-card-header">
                            <img class="rounded-circle" src="/storage/avatar/{{$latest_topic->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$latest_topic->author}} </b>
                    </div><br>

                    <div class="uk-card-title">
                        <b> {{$latest_topic->title}} </b>
                    </div> <br>

                    <div class="uk-card-body">
                        {{$latest_topic->message}}
                    </div>

                    <div>
                        @if ($latest_topic->file_extension !== 'none')
                            
                            @if ($latest_topic->file_extension == 'jpg' || $latest_topic->file_extension == 'jpeg' || $latest_topic->file_extension == 'png' || $latest_topic->file_extension == 'gif')
                                <a href="/storage/topic_files/{{$latest_topic->file}}"> <img src="/storage/topic_files/{{$latest_topic->file}}" height="100%" width="100%"> </a>
                            @else
                                <a href="/storage/topic_files/{{$latest_topic->file}}"> Open the file </a>
                            @endif
                        @endif
                    </div>

                    <div class="uk-card-footer"> <br />
                        <b> <b> {{date('d-M-Y H:i', strtotime($latest_topic->created_at))}} </b> </b>
                    </div>

                    <div style="text-align:right";>
                        <b> <a href="/topic/{{$latest_topic->id}}"> See more </a> </b>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection