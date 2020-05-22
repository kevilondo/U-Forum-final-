@extends('layout.app')

@section('content')
    <div class="container mt-2">
        @if (count($notifs) > 0)
            @foreach ($notifs as $notif)
                @if ($notif->seen == "0")
                    @if ($notif->notif_type == "staff_message")
                        <a href="/comment/seen/{{$notif->staff_message_id}}/{{$notif->id}}">
                            <div class="uk-card uk-card-default uk-card-hover">
                                @if (isset($notif->user))
                                    <p> <img src="/storage/avatar/{{$notif->user->avatar}}" height="5%" width="5%" class="rounded-circle"> {{$notif->user->name. " ". $notif->user->surname. " ". $notif->message}} <img src="/assets/blue_dot.png" height="3%" width="3%"> </p>
                                @else
                                    <p> <img src="/storage/avatar/default.png" height="5%" width="5%" class="rounded-circle"> {{$notif->staff->first_name. " ". $notif->staff->surname. " ". $notif->message}} <span style="font-size: 11px">(Staff)</span> <img src="/assets/blue_dot.png" height="3%" width="3%"> </p>
                                @endif
                            </div>
                        </a>
                    @else
                        <a href="/comment/seen/{{$notif->topic_id}}/{{$notif->id}}">
                            <div class="uk-card uk-card-default uk-card-hover">
                                @if (isset($notif->user))
                                    <p> <img src="/storage/avatar/{{$notif->user->avatar}}" height="5%" width="5%" class="rounded-circle"> {{$notif->user->name. " ". $notif->user->surname. " ". $notif->message}} <img src="/assets/blue_dot.png" height="3%" width="3%"> </p>
                                @else
                                    <p> <img src="/storage/avatar/default.png" height="5%" width="5%" class="rounded-circle"> {{$notif->staff->first_name. " ". $notif->staff->surname. " ". $notif->message}} <span style="font-size: 11px">(Staff)</span> <img src="/assets/blue_dot.png" height="3%" width="3%"> </p>
                                @endif
                            </div>
                        </a>
                    @endif
                @else
                    @if ($notif->notif_type == "staff_message")
                        <a href="/comment/seen/{{$notif->staff_message_id}}/{{$notif->id}}">
                            <div class="uk-card uk-card-default uk-card-hover">
                                @if (isset($notif->user))
                                    <p> <img src="/storage/avatar/{{$notif->user->avatar}}" height="5%" width="5%" class="rounded-circle"> {{$notif->user->name. " ". $notif->user->surname. " ". $notif->message}} </p>
                                @else
                                    <p> <img src="/storage/avatar/default.png" height="5%" width="5%" class="rounded-circle"> {{$notif->staff->first_name. " ". $notif->staff->surname. " ". $notif->message}} <span style="font-size: 11px">(Staff)</span> </p>
                                @endif
                            </div>
                        </a>
                    @else
                        <a href="/comment/seen/{{$notif->topic_id}}/{{$notif->id}}">
                            <div class="uk-card uk-card-default uk-card-hover">
                                @if (isset($notif->user))
                                    <p> <img src="/storage/avatar/{{$notif->user->avatar}}" height="5%" width="5%" class="rounded-circle"> {{$notif->user->name. " ". $notif->user->surname. " ". $notif->message}} </p>
                                @else
                                    <p> <img src="/storage/avatar/default.png" height="5%" width="5%" class="rounded-circle"> {{$notif->staff->first_name. " ". $notif->staff->surname. " ". $notif->message}} <span style="font-size: 11px">(Staff)</span> </p>
                                @endif
                            </div>
                        </a>
                    @endif
                @endif    
            @endforeach
        @else
            <div style="text-align:center">
                <p>No notifications</p>
            </div>
        @endif
    </div>
@endsection