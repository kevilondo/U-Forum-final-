<nav class="uk-navbar uk-background-secondary" data-uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
    <a class="uk-navbar-brand" href="/mavuti-home"> <img src="/assets/logo.png" height="100px" width="160px"> </a>
    <a href="#offcanvas" uk-toggle style="margin-left:45%; margin-top:50px; font-size:24px">&#9776;Menu</a>
</nav>

<div id="offcanvas" uk-offcanvas="flip: true">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-offcanvas">
            <div style="margin-left: 40px;">{{Auth::guard('staff')->user()->first_name. " ". Auth::guard('staff')->user()->surname}}</div>
            <img class="img-responsive" uk-img height="140px" width="140px" style="margin-top: 15px"; src="/assets/logo.png">
            <li class="nav-item"> <a class="nav-link" href="/mavuti-home"> <img src="/assets/house.png" title="Home" height="30px" width="30px">Home </a> </li>
            <li class="nav-item"> <a class="nav-link" href="/contact_users"> <img src="/assets/inbox.png" title="Inbox" height="30px" width="30px">Post message for students</a> </li>
            <li class="nav-item" style="margin-left:-10px;"> <a class="nav-link" href="/notifications"> <img src="/assets/bell.png" title="Notifications" height="40px" width="40px"> Notifications ({{$notifCount}}) </a> </li>
            <li class="nav-item"> <a class="nav-link" href="/staff_messages"> <img src="/assets/staff.png" title="Staff" height="30px" width="30px"> Staff Messages </a> </li>
            <li class="nav-item"> <a class="nav-link" href="/list_topics"> <img src="/assets/forum.png" title="Forum" height="30px" width="30px"> Topics </a> </li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="/assets/logout.png" title="Log out" height="30px" width="30px"> 
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                    </form>
            </li>
        </ul>
        <button class="uk-offcanvas-close" type="button" uk-close></button>
    </div>
</div>