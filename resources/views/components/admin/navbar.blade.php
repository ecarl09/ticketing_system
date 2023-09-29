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
                    <a class="nav-link @if(Route::is('admin.dashboard')) active @endif" href="{{route('admin.dashboard')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-home"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">APP</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
                    </div>
                    <!-- parent pages-->
                    <a class="nav-link @if(Route::is('admin.ticket.list')) active @endif" href="{{route('admin.ticket.list')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-ticket-alt"></span></span>
                            <span class="nav-link-text ps-1">Tickets</span>
                        </div>
                    </a>

                    <a class="nav-link @if(Route::is('resolved.ticket')) active @endif" href="{{route('resolved.ticket')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-ticket-alt"></span></span>
                            <span class="nav-link-text ps-1">Resolved Tickets</span>
                        </div>
                    </a>

                    <a class="nav-link @if(Route::is('reports.list')) active @endif" href="{{route('reports.list')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="far fa-list-alt"></span></span>
                            <span class="nav-link-text ps-1">Reports</span>
                        </div>
                    </a>
                </li>

                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">NEWS AND UPDATE</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
                    </div>

                    <!-- parent pages-->
                    <a class="nav-link dropdown-indicator" href="#multi-level" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="multi-level">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon">
                                <span class="fas fa-pencil-alt"></span>
                            </span>
                            <span class="nav-link-text ps-1">Compose</span>
                        </div>
                    </a>
                    <ul class="nav collapse false @if(Route::is('compose.news') || Route::is('create.events') ) show @endif" id="multi-level">
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('compose.news')) active @endif" href="{{route('compose.news')}}" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="far fa-newspaper"></span></span>
                                    <span class="nav-link-text ps-1">Compose News</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Route::is('create.events')) active @endif" href="{{route('create.events.form')}}" role="button" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon"><span class="fas fa-calendar-day"></span></span>
                                    <span class="nav-link-text ps-1">Create Event</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <a class="nav-link @if(Route::is('read.news')) active @endif" href="{{route('read.news')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fab fa-readme"></span></span>
                            <span class="nav-link-text ps-1">Read News</span>
                        </div>
                    </a>


                </li>

                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">SETTINGS</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider"/></div>
                    </div>
                    <!-- parent pages-->
                    <a class="nav-link @if(Route::is('view.all.users')) active @endif" href="{{route('view.all.users')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                            <span class="fas fa-users"></span></span>
                            <span class="nav-link-text ps-1">User List</span>
                        </div>
                    </a>
                    <a class="nav-link @if(Route::is('add.user.form')) active @endif" href="{{route('add.user.form')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                            <span class="fas fa-user-plus"></span></span>
                            <span class="nav-link-text ps-1">Users Registration</span>
                        </div>
                    </a>
                    <a class="nav-link @if(Route::is('validate.user')) active @endif" href="{{route('validate.user')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                            <span class="fas fa-user-lock"></span></span>
                            <span class="nav-link-text ps-1">User Validation</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>