@extends('layout.app')

@section('content')
    <div class="container mt-4">
        @foreach ($users as $user)
            @if (isset($user[0]))
                @if (in_array($user[0]->id, $unread_users))

                    <a href="/chat/{{$user[0]->id}}/#message">
                        <div class="uk-card uk-card-default uk-card-hover">
                            <p> <img src="/storage/avatar/{{$user[0]->avatar}}" height="5%" width="5%" class="rounded-circle"> <b> {{$user[0]->name. " ". $user[0]->surname}} </b> <img src="/assets/blue_dot.png" height="3%" width="3%"> </p>
                        </div>
                    </a>

                @else
                    
                    <a href="/chat/{{$user[0]->id}}/#message">
                        <div class="uk-card uk-card-default uk-card-hover">
                            <p> <img src="/storage/avatar/{{$user[0]->avatar}}" height="5%" width="5%" class="rounded-circle"> {{$user[0]->name. " ". $user[0]->surname}}  </p>
                        </div>
                    </a>

                @endif
            @endif

        @endforeach
        
    </div>
@endsection