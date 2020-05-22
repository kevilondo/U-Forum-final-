@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <p> {{auth()->user()->name. " ". auth()->user()->surname}} </p>
                <img class="img-responsive rounded-circle" uk-img height="140px" width="140px" style="margin-top: 15px"; src="/storage/avatar/{{auth()->user()->avatar}}">
            </div>

            <div class="col-md-6">

                <div class="mt-5">
                    <div>
                        <div>
                            <a href="/forum">See all topics</a>
                        </div> <br>
    
                        <div>
                            <a href="/forum/course">Topics posted by students in my course</a>
                        </div>
                    </div>
                </div>

                <button class="button"  onclick="addTopic();"> Create a topic </button> <br>

                <form method="post" class="col-md-8" id="topic_form" action="" enctype="multipart/form-data" style="border: none; display: none;">
                    {{ csrf_field() }}
                    <p> Title <input type="text" class="form-control" name="title" placeholder="Write a title"> </p>
                    <textarea name="message" class="form-control" rows="4" cols="35" placeholder="Write your message here!"></textarea><br />
                    <p> Insert a file (optional) <input type="file" class="form-control" name="file" /></p>
                    <input type="submit" class="submit button" name="submit" value="Submit">
                </form>

                @if (count($posts) > 0)
                    @foreach ($posts as $post)

                        <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
                            <div class="uk-card-header">
                                    <img class="rounded-circle" src="/storage/avatar/{{$post->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$post->author}} </b>
                            </div><br>

                            <div class="uk-card-title">
                                <b> {{$post->title}} </b>
                            </div> <br>

                            <div class="uk-card-body">
                                {{$post->message}}
                            </div>

                            <div>
                                @if ($post->file_extension !== 'none')
                                    
                                    @if ($post->file_extension == 'jpg' || $post->file_extension == 'jpeg' || $post->file_extension == 'png' || $post->file_extension == 'gif')
                                        <a href="/storage/topic_files/{{$post->file}}"> <img src="/storage/topic_files/{{$post->file}}" height="100%" width="100%"> </a>
                                    @else
                                        <a href="/storage/topic_files/{{$post->file}}"> Open the file </a>
                                    @endif
                                @endif
                            </div>

                            <div class="uk-card-footer"> <br />
                                <b> {{date('d-M-Y H:i', strtotime($post->created_at))}} </b>
                            </div>

                            <div style="text-align:right";>
                                <b> <a href="/comment/{{$post->id}}"> Comment </a> </b>
                            </div>

                        </div>
                    @endforeach
                        <div class="content"> 
                            {{$posts->links()}} 
                        </div>
                @else
                    <h3>
                        No post available
                    </h3>
                @endif
            </div>

        </div>
    </div>

@endsection