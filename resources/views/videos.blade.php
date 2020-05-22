@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
               <form class="col-md-12" action="" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    Title: <input type="text" name="title" class="form-control"><br>
                    <input type="file" name="video" class="form-control">
                    <input type="submit" value="Upload video" class="button"><br>
                </form>
            </div>

            <div class="col-md-6">
 
                @if (count($videos) > 0)
                    <div class="mt-5">
                        @foreach ($videos as $video)
                            <div class="uk-card uk-card-default uk-card-hover mb-5">
                                <div class="uk-card-header">
                                    <h3>
                                        <img src="/storage/avatar/{{$video->user->avatar}}" class="rounded-circle" width="70px" height="70px">
                                        {{$video->user->name. " ". $video->user->surname}}
                                    </h3>
                                    <div class="uk-card-title">
                                        <b>{{$video->title}}</b>
                                    </div>
                                    <div class="uk-card-body">
                                        <video controls width="320px" height="240px">
                                            <source src="/storage/videos/{{$video->file}}" type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="uk-card-footer">
                                        <b> {{date('d-M-Y H:i', strtotime($video->created_at))}} </b>
                                    </div>
                                    @if ($video->user->id !== auth()->user()->id)
                                        <div style="text-align:center";>
                                            <b> <a href="/chat/{{$video->user->id}}/#message"> Contact this user </a> </b>
                                        </div>
                                    @else
                                        <div style="text-align:center";>
                                            <b> <a href="/video_delete/{{$video->id}}"> Delete this item </a> </b>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="content"> 
                            {{$videos->links()}} 
                        </div>
                    </div>
                @else
                    <div style="margin-top: 100px">
                        <h3>No video has been uploaded yet</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection