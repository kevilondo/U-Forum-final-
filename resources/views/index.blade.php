@extends('layout.app')

@section('content')

    @if (Auth::guest())
         
        <div class="container" style="margin-top:20px;">
            <p>You are not logged in. <a class="logIn" href="/login"> Log in </a> OR <a class="signUp" href="/register"> Sign up</a> to have access to the forum and interact with other students </p>
            <h3>On this platform, you can sell textbooks or any stationery, share notes/exam papers,  discuss with other students, and more!</h3>
            <h3>Post videos and help other students with your teaching skills!</h3>

            <h2>U-Forum is the platform made by students, for students!</h2>
        </div>
        
    @endif

    @if (count($staff_messages) > 0)
        @if (!Auth::guest())
            <div class="container">
                <h3 class="latest">-Messages from staff-</h3>

                @foreach ($staff_messages as $staff_message)
                    @if ($staff_message->university == auth()->user()->university)
                        <div class="col-md-10">
                            <div class="uk-card uk-card-large uk-card-hover uk-card-default">
                                <div class="uk-card-header">
                                    <h3> {{$staff_message->staff->first_name. " ". $staff_message->staff->surname}} </h3>
                                </div>

                                <div class="uk-card-body">
                                    {{$staff_message->message}}

                                </div>    

                                    @if ($staff_message->file !== null || $staff_message->file !== 'none')
                                        <div class="container">
                                            <p> <a href="/storage/staff_files/{{$staff_message->file}}">Click here to open file</a> </p>
                                        </div>
                                    @endif
                                

                                <div class="uk-card-footer">
                                    <b> {{date('d-M-Y H:i', strtotime($staff_message->created_at))}} </b> <br>
                                </div>
                                <div style="text-align: right">
                                    <a href="/staff_message/{{$staff_message->id}}">Comment</a>
                                </div>
                            </div>
                        </div> <br>
                    @endif
                @endforeach
            </div>
        @endif
    
    @endif

        <div class="container-fluid mt-5">
            <div class="row">

                <div class="col-md-4 mt-5">
                    <h3 class="latest">-Community-</h3>

                    <div class="uk-card uk-card-default uk-card-hover mt-3">
                        @foreach ($rand_users as $rand_user)
                            <p> <img src="/storage/avatar/{{$rand_user->avatar}}" height="70px" width="70px" class="rounded-circle"> <b> {{$rand_user->name. " ". $rand_user->surname}} </b> <a href="/chat/{{$rand_user->id}}" style="color:black !important;"> <span class="ml-3"> <img src="/assets/inbox.png" width="30px" height="30px"> </span> </a> </p>
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
                                    <b> {{date('d-M-Y H:i', strtotime($book->created_at))}} </b>
                                </div>

                                @if (Auth::guest())
                                    <div style="text-align:center";>
                                        <b> Log in or Sign up to contact this user </b>
                                    </div>
                                @elseif($book->user->id !== auth()->user()->id)
                                    <div style="text-align:center";>
                                        <b> <a href="/chat/{{$book->user->id}}/#message"> Contact this user </a> </b>
                                    </div>
                                @elseif(auth()->user()->role == 'admin')
                                    <div style="text-align:center";>
                                        <b> <a href="/delete/{{$book->id}}"> Delete this item </a> </b>
                                    </div>
                                @endif

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
                                <b> {{date('d-M-Y H:i', strtotime($latest_topic->created_at))}} </b>
                            </div>

                            <div style="text-align:right";>
                                <b> <a href="/comment/{{$latest_topic->id}}"> Comment </a> </b>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection

