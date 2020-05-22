<body>
    <img src="http://127.0.0.1:8000/assets/logo.png" width="120px" height="120px">

    <p>Hello, {{$data['name']}} </p>

    <p> {{$data['message']}} </p> <br>

    <p> <b> Topic title: {{$data['topic_title']}} </b> </p> <br>

    <p> {{$data['topic_message']}} </p> <br>

    <a href="{{$data['url']}}" style="background-color : orange;
	border : none;
	margin-top: 20px;
	padding: 15px 32px;
	text-align: center;
	color: white;">
        Log In to U-Forum
    </button>
</body>