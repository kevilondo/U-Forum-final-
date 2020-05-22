@extends('layout.app')

@section('content')
    <div class="container mt-2">

        <div class="card card-default">
            <div class="card-title text-center mt-3">
                <p> <img class="rounded-circle" src="/storage/avatar/{{$user->avatar}}" width="50px" height="50px"> {{$user->name." ". $user->surname}} </p>
            </div>
        </div>

        @if (count($chats) > 0)        
            @foreach ($chats as $chat)

                @if ($chat->id_sender !== auth()->user()->id)
                    
                    @if ($chat->file == null)

                        <div class="mt-4 mb-4 card chat-bg" style="width: 58%">
                            <p style="color: white"> {{$chat->message}} </p>
                            <small style="color: white"> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                        </div> <br>
                    @else 
                    
                        <div class="mt-4 mb-4 card chat-bg" style="width: 58%">
                            @if (!in_array($chat->file_extension, $image_extensions))
                                <a href="/storage/inbox/{{$chat->file}}"> <p> {{$chat->file}} </p> </a>
                                <small style="color: white"> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                            @else
                                <div class="align-right">
                                    <a href="/storage/inbox/{{$chat->file}}"> <img src="/storage/inbox/{{$chat->file}}" width="50%" height="50%"> </a>
                                </div>
                                <small style="color: white"> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                            @endif
                        </div> <br>
                    @endif

                @endif
                
                @if ($chat->id_sender == auth()->user()->id)

                    @if ($chat->file == null)

                        <div class="mt-4 mb-4 align-right card" style="width: 58%">
                            <p> {{$chat->message}} </p>
                            <small> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                        </div> <br>

                    @else

                        <div class="mt-4 mb-4 align-right card" style="width: 58%">
                            @if (!in_array($chat->file_extension, $image_extensions))
                                <a href="/storage/inbox/{{$chat->file}}"> <p> {{$chat->file}} </p> </a>
                                <small> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                            @else
                                <div class="align-right">
                                    <a href="/storage/inbox/{{$chat->file}}"> <img src="/storage/inbox/{{$chat->file}}" width="50%" height="50%"> </a>
                                </div>
                                <small> {{date('d-M-Y H:i', strtotime($chat->created_at))}} </small>
                            @endif
                        </div> <br>

                    @endif
                    

                @endif
            @endforeach
        @endif
            <form class="mt-5 col-md-12" action="" method="POST">
                <textarea class="form-control" name="message" id="message" cols="20" rows="4"></textarea>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-info" name="send_message" value="Send"> 
            </form>

            <form class="mt-5 col-md-12" action="/files/{{$user->id}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="file" name="files[]" multiple>
                <input type="submit" class="btn btn-info" name="send_files" value="Send files"> 
            </form>
    </div>

@endsection