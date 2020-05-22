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
                            <a href="/bookstore">See all offers</a>
                        </div> <br>
    
                        <div>
                            <a href="/bookstore/course">Offers posted by students in my course</a>
                        </div>
                    </div>
                </div>

                <button class="button"  onclick="addTopic();"> Post an offer </button> <br>

                <form method="post" class="col-md-8" id="topic_form" action="" enctype="multipart/form-data" style="border: none; display: none;">
                    {{ csrf_field() }}
                    <p> Title <input type="text" class="form-control" name="title" placeholder="What are you selling?/looking for?"> </p>
                    <textarea name="description" class="form-control" rows="4" cols="30" placeholder="Write your message here!"></textarea><br />
                    <p> Insert a file (optional) <input class="form-control" type="file" name="file" /></p>
                    <input type="submit" class="submit button" name="submit" value="Submit">
                </form>

                @if (count($books) > 0)
                    @foreach ($books as $book)

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

                            @if ($book->user->id !== auth()->user()->id)
                                <div style="text-align:center";>
                                    <b> <a href="/chat/{{$book->user->id}}/#message"> Contact this user </a> </b>
                                </div>
                            @else
                                <div style="text-align:center";>
                                    <b> <a href="/delete/{{$book->id}}"> Delete this item </a> </b>
                                </div>
                            @endif

                        </div>
                    @endforeach
                        <div class="content"> 
                            {{$books->links()}} 
                        </div>
                @else
                        <h3>
                            No offer has been posted yet
                        </h3>
                @endif
            </div>
        </div>
    </div>

@endsection