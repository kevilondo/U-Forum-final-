@extends('layout.app')

@section('content')

    <div class="container">
        <form class="mt-5 col-md-12" action="" method="POST" enctype="multipart/form-data">
            <textarea class="form-control" name="message" id="message" cols="20" rows="4"></textarea>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="file" name="file" /> <br>
            <input type="submit" class="button" name="submit" value="Post message"> 
        </form>
    </div>

    @if (count($staff_messages) > 0)

        <div class="container">
            <h3 class="latest">-Messages from staff-</h3>

            @foreach ($staff_messages as $staff_message)
                <div class="col-md-10">
                    <div class="uk-card uk-card-large uk-card-hover uk-card-default">
                        <div class="uk-card-header">
                            <b> {{$staff_message->staff->first_name. " ". $staff_message->staff->surname}} </b>
                        </div>

                        <div class="uk-card-body">
                            {{$staff_message->message}}

                        </div>    

                            @if ($staff_message->file !== null)
                                <div class="container">
                                    <p> <a href="/storage/staff_files/{{$staff_message->file}}">Click here to open file</a> </p>
                                </div>
                            @endif
                        

                        <div class="uk-card-footer">
                            <b> {{$staff_message->date_time}} </b>
                        </div>

                        @if (Auth::guard('staff')->user()->id == $staff_message->staff_id)
                            <div class="container">
                                <a href="/delete_staff_message/{{$staff_message->id}}"> Delete this message </a>
                            </div>
                        @endif
                    </div>
                </div> <br>
            @endforeach
        </div>
    
    @endif

    
@endsection