<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

<button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
    <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
</button>
<a class="navbar-brand me-1 me-sm-3" href="../index.html">
    <div class="d-flex align-items-center">
        <span class="font-sans-serif">Fedcis Portal</span>
    </div>
</a>

<ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
    <li class="nav-item dropdown">
        <a class="nav-link px-0 fa-icon-wait" href="#!" role="button" >
            <span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="avatar avatar-xl">
                <img class="rounded-circle" src="{{asset('/storage/profile_picture/'.Auth::user()['profile_picture'])}}" alt="" />
            </div>
        </a>

        <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
            <div class="bg-white dark__bg-1000 rounded-2 py-2">
                <a class="dropdown-item fw-bold text-warning" href="#!">
                    <span class="fas fa-user me-1"></span><span>{{Auth::user()['firstName'].' '.Auth::user()['lastName']}}</span>
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('users.account') }}">Profile &amp; account</a>
                <a class="dropdown-item" href="{{ route('users.update.password') }}">Security</a>
                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </li>
</ul>
</nav>