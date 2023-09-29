<nav class="navbar navbar-light navbar-vertical navbar-expand-xl navbar-card">


    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
        </div>
        <a class="navbar-brand" href="#!">
            <div class="d-flex align-items-center py-3">
                <!-- <img class="me-2" src="../assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" /> -->
                <span class="font-sans-serif">IT SUPPORT</span>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                <li class="nav-item">
                    <!-- parent pages-->
                    <a class="nav-link @if(Route::is('users.dashboard')) active @endif" href="{{route('users.dashboard')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-home"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">App</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
                    </div>
                    <!-- parent pages-->
                    <a class="nav-link @if(Route::is('ticket.list')) active @endif" href="{{route('ticket.list')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-ticket-alt"></span></span>
                            <span class="nav-link-text ps-1">Tickets</span>
                        </div>
                    </a>

                    <a class="nav-link @if(Route::is('create.ticket.form')) active @endif" href="{{route('create.ticket.form')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-pencil-alt"></span></span>
                            <span class="nav-link-text ps-1">Open New Ticket</span>
                        </div>
                    </a>

                    <a class="nav-link @if(Route::is('user.ticket.reports')) active @endif" href="{{route('user.ticket.reports')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="far fa-list-alt"></span></span>
                            <span class="nav-link-text ps-1">Reports</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">News</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
                    </div>
                    <a class="nav-link @if(Route::is('news.list')) active @endif" href="{{route('news.list')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fab fa-readme"></span></span>
                            <span class="nav-link-text ps-1">Read News</span>
                        </div>
                    </a> 
                </li>
            </ul>
        </div>
    </div>
</nav>