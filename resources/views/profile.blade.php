@extends('layout.app')

@section('content')
    <div class="content">
        <div>{{$user->name. " ". $user->surname}}</div>
        <img src="/storage/avatar/{{$user->avatar}}" class="rounded-circle" height="30%" width="30%"> <br>
        
        <input type="button" class="button" onclick="displayEditAvatar();" value="Edit your profile picture" />
        <form method="post" id="edit_avatar" action="" enctype="multipart/form-data" style="border: none; display: none;">
            {{ csrf_field() }}
			<input type="file" name="new_avatar" />
			<input type="submit" class="button" name="edit" value="Edit your profile picture" />
        </form><br>
        
        <input type="button" class="button" onclick="displayChangePassword();" value="Change your password" />
        <form method="post" id="change_password" action="/password" style="border: none; display: none;">
                {{ csrf_field() }}
			Password <input type="password" name="old_password" /> <br /> <br />
			New Password <input type="password" name="new_password" /> <br /> <br />
			Confirm New Password <input type="password" name="new_password_conf" /> <br />
			<input type="submit" class="button" name="change" value="Confirm" /> <br />
        </form><br>
        
        <input type="button" class="button" onclick="displayDeleteAccount();" value="Delete your account" style="margin-top: 10px" />
        <form method="post" id="delete_account" action="/delete_account" style="border: none; display: none;">
                {{ csrf_field() }}
			Password <input type="password" name="password" /> <br /> <br />
			<input type="submit" class="button" name="delete" value="Confirm" />
		</form>
    </div>
@endsection