<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/custom.css">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/css/uikit.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.3/dist/js/uikit-icons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


        <title>{{ config('app_name', 'U-Forum')}} </title>
    </head>

    <body>
        @if (Auth::guard('staff')->check())

            @include('inc.staffnavbar')

        @else

            @include('inc.navbar')

        @endif
        
        
        @include('inc.messages')
        
        @yield('content')

        <script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
        <script src="/js/bookstore.js"></script>
        <script src="/js/topic.js"></script>
        <script src="/js/roommate.js"></script>
        <script src="/js/script.js"></script>

        <script>
            CKEDITOR.replace( 'article' );
        </script>
    </body>

    <footer class="bg-dark">
        <div class="container">
            <div>
                <img src="/assets/logo.png">
            </div><br>

            <div>
                <p style="color:white">Follow us on social medias: </p>
                <a href="https://instagram.com/_uforum_" target="blank"> <img src="/assets/instagram.png" width="40px" height="40px"> </a>
                <a href="https://facebook.com/UForum1" target="blank"> <img src="/assets/facebook.png" width="35px" height="35px" style="margin-left:20px"> </a>
            </div><br>

            <div>
                <a href="/contact"> Contact us </a>
                <a href="/about" style="margin-left:20px"> About us </a>
            </div> <br>

            <div style="color:white">
                © {{date('Y')}} U-Forum all rights reserved
            </div>
            
        </div>
    </footer>
    
</html>