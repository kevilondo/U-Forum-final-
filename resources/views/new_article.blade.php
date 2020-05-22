@extends('layout.app')

@section('content')

    @if (isset($success))
        <div class="alert alert-success">
            {{$success}}
        </div>
    @endif
    
    <div class="article_editor">
        
        <form class="editor" action="" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="text" name="title" placeholder="Title" required>
            <textarea name="article" cols="65" rows="35"></textarea>
            <input type="submit" class="button" value="Submit your article" name="submit">
        </form>
    </div>

@endsection