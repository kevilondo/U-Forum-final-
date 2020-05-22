@extends('layout.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                
            </div>

            <div class="col-md-5">

                @if (count($topics) > 0)
                    @foreach ($topics as $topic)

                        <div class="uk-card uk-card-default uk-card-hover mt-3" style="text-align:center">
                            <div class="uk-card-header">
                                    <img class="rounded-circle" src="/storage/avatar/{{$topic->user->avatar}}" heigth="70px" width="70px" uk-img/> <b> {{$topic->author}} </b>
                            </div><br>

                            <div class="uk-card-title">
                                <b> {{$topic->title}} </b>
                            </div> <br>

                            <div class="uk-card-body">
                                {{$topic->message}}
                            </div>

                            <div>
                                @if ($topic->file_extension !== 'none')
                                    
                                    @if ($topic->file_extension == 'jpg' || $topic->file_extension == 'jpeg' || $topic->file_extension == 'png' || $topic->file_extension == 'gif')
                                        <a href="/storage/topic_files/{{$topic->file}}"> <img src="/storage/topic_files/{{$topic->file}}" height="100%" width="100%"> </a>
                                    @else
                                        <a href="/storage/topic_files/{{$topic->file}}"> Open the file </a>
                                    @endif
                                @endif
                            </div>

                            <div class="uk-card-footer"> <br />
                                <b> {{date('d-M-Y H:i', strtotime($topic->created_at))}} </b>
                            </div>

                            <div style="text-align:right";>
                                <b> <a href="/topic/{{$topic->id}}"> See more </a> </b>
                            </div>

                        </div>
                    @endforeach
                        <div class="content"> {{$topics->links()}} </div>
                @endif
            </div>

            <div class="col-md-4">
                
            </div>
        </div>
    </div>

@endsection