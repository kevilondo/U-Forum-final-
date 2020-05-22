@extends('layout.app')

@section('content')
    @if(count($messages) > 0)
        @foreach ($messages as $message)
            <div class="container mt-5">
                <div class="col-md-10">
                    <div class="uk-card uk-card-large uk-card-hover uk-card-default">
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
                            <b> {{$message->date_time}} </b> <br>
                        </div>
                        <div style="text-align: right">
                            <a href="/staff_message/{{$message->id}}">Comment</a>
                        </div>
                    </div>
                </div> <br>
            </div>
        @endforeach
    @endif
@endsection