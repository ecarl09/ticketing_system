@extends('layouts.UsersMainLayouts')

@section('current-page-title') Chapter Dashboard @endsection
@section('current-page-title-icon') fas fa-home @endsection

@section('usersContent')
<div class="row g-3">
    <div class="col-xxl-6 col-lg-6">
        <div class="row g-3">
            <div class="col-xxl-12 col-lg-6">
                <div class="card h-100">
                    <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);"></div>
                    <!--/.bg-holder-->
                    <div class="card-header z-index-1">
                        <h5 class="text-primary">Welcome to Fedcis Portal! </h5>
                        <h6 class="text-600">Here are some quick links for you to start </h6>
                    </div>
                    <div class="card-body z-index-1">
                        <div class="row g-2 h-100 align-items-end">
                            <div class="col-sm-6 col-md-5">
                                <div class="d-flex position-relative">
                                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-ticket-alt text-primary"></span></div>
                                    <div class="flex-1">
                                        <a class="stretched-link" href="{{route('ticket.list')}}">
                                            <h6 class="text-800 mb-0">Tickets</h6>
                                        </a>
                                        <p class="mb-0 fs--2 text-500">View all your ticket and status</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <div class="d-flex position-relative">
                                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-users text-warning"></span></div>
                                    <div class="flex-1">
                                        <a class="stretched-link" href="{{route('create.ticket.form')}}">
                                            <h6 class="text-800 mb-0">Create Ticket</h6>
                                        </a>
                                        <p class="mb-0 fs--2 text-500">Create and manage your concern</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-5">
                                <div class="d-flex position-relative">
                                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="far fa-newspaper text-success"></span></div>
                                    <div class="flex-1"><a class="stretched-link" href="{{route('news.list')}}">
                                        <h6 class="text-800 mb-0">News And Updates</h6>
                                        </a>
                                        <p class="mb-0 fs--2 text-500">See what's new in MMG Federation</p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6 col-md-5">
                                <div class="d-flex position-relative">
                                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="far fa-file-alt text-info"></span></div>
                                    <div class="flex-1"><a class="stretched-link" href="#!">
                                        <h6 class="text-800 mb-0">Reports</h6>
                                        </a>
                                        <p class="mb-0 fs--2 text-500">Monitor activity and reports</p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6 col-md-6">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-1.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6>
                                    Total tickets
                                    <!-- <span class="badge badge-soft-warning rounded-pill ms-2">-0.23%</span> -->
                                </h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning" data-countup='{"endValue":{{$tickets}},"decimalPlaces":0,"suffix":""}'>
                                    {{$tickets}}
                                </div>
                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('ticket.list')}}">
                                    See all
                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-2.png);"></div>
                            <!--/.bg-holder-->
                            <div class="card-body position-relative">
                                <h6>
                                    Active tickets
                                    <!-- <span class="badge badge-soft-info rounded-pill ms-2">0.0%</span> -->
                                </h6>
                                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info" data-countup='{"endValue":{{$currentTicket}},"decimalPlaces":0,"suffix":""}'>
                                    {{$currentTicket}}
                                </div>
                                <a class="fw-semi-bold fs--1 text-nowrap" href="{{route('ticket.list')}}">
                                    See all
                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-6 col-lg-6">
        <div class="card bg-transparent-50 overflow-hidden">
            <div class="card-header position-relative" style="height: 14vh;">
                <div class="bg-holder d-none d-md-block bg-card z-index-1" style="background-image:url(../assets/img/illustrations/ecommerce-bg.png);background-size:230px;background-position:right bottom;z-index:-1;"></div>
                <!--/.bg-holder-->
                <div class="position-relative z-index-2">
                    <div>
                        <h3 class="text-primary mb-1">You may interested</h3>
                        <p>Here’s our other website you may want to visit</p>
                    </div>

                </div>
            </div>

            <div class="card-body p-0">
                <ul class="mb-0 list-unstyled">
                    <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                        <div class="row flex-between-center">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="fas fa-home mt-1 fs--2 text-primary"></div>
                                    <p class="fs--1 ps-2 mb-0">www.mmgphil.org</p>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <a class="alert-link fs--1 fw-medium" href="https://mmgphil.org/" target="_blank">View<i class="fas fa-chevron-right ms-1 fs--2"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                        <div class="row flex-between-center">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="fas fa-book-open mt-1 fs--2 text-primary"></div>
                                    <p class="fs--1 ps-2 mb-0">www.thelibrary.mmgphil.org</p>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <a class="alert-link fs--1 fw-medium" href="http://thelibrary.mmgphil.org/" target="_blank">View<i class="fas fa-chevron-right ms-1 fs--2"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                        <div class="row flex-between-center">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="fas fa-store mt-1 fs--2 text-primary"></div>
                                    <p class="fs--1 ps-2 mb-0">www.fedportal.mmgphil.org</p>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <a class="alert-link fs--1 fw-medium" href="https://fedportal.mmgphil.org/" target="_blank">View<i class="fas fa-chevron-right ms-1 fs--2"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="alert mb-0 rounded-0 py-3 px-card greetings-item border-top  border-0">
                        <div class="row flex-between-center">
                            <div class="col">
                                <div class="d-flex">
                                    <div class="fas fa-hospital mt-1 fs--2 text-primary"></div>
                                    <p class="fs--1 ps-2 mb-0">www.Telemmg.com</p>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <a class="alert-link fs--1 fw-medium" href="https://telemmg.com/" target="_blank">View<i class="fas fa-chevron-right ms-1 fs--2"></i></a>
                            </div>
                        </div>
                    </li>              
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card" id="customersTable" data-list='{"valueNames":["name","chapter","code","ticketType","status"],"page":5,"pagination":true}'>
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Current tickets</h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0" style="height: 30vh; overflow-y:hidden">
                <div class="table-responsive">
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="chapter">Chapter</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="code">Code</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="ticketType">Ticket Type</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach($list as $data)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <a href="#!">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <img class="rounded-circle" src="{{asset('/storage/profile_picture').'/'.$data->profile_picture}}" alt="">
                                                </div>
                                                <div class="flex-1 ps-2">
                                                    <h5 class="mb-0 fs--1" style="text-transform: capitalize">{{$data->firstName.' '.$data->lastName}}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{$data->chapterName}}</td>
                                    <td class="code align-middle white-space-nowrap py-2">{{$data->ticket_code}}</td>
                                    <td class="ticketType align-middle white-space-nowrap py-2">{{$data->ticket_type}}</td>
                                    <td class="status align-middle py-2">
                                        @if($data->status == 'NEW')
                                            <span class="badge rounded-pill bg-secondary">{{ $data->status }}</span>
                                        @elseif($data->status == 'OPENED')
                                            <span class="badge rounded-pill bg-primary">{{ $data->status }}</span>
                                        @elseif($data->status == 'ACTION TAKEN')
                                            <span class="badge rounded-pill bg-warning">{{ $data->status }}</span>
                                        @elseif($data->status == 'AWAITING REPLY')
                                            <span class="badge rounded-pill bg-info">{{ $data->status }}</span>
                                        @elseif($data->status == 'ON HOLD')
                                            <span class="badge rounded-pill bg-danger">{{ $data->status }}</span>
                                        @elseif($data->status == 'RESOLVED')
                                            <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                        @elseif($data->status == 'CLOSED')
                                            <span class="badge rounded-pill bg-success">{{ $data->status }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <a href="{{ route('ticket.details', $data->id)}}">View</a>
                                    </td>
                                </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul>
                <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
        </div>
    </div>

    <div class="col-lg-4 ps-lg-2">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">News and update</h5>
                    </div>
                </div>
            </div>
            <div class="card-body fs--1 p-0" style="height: 30vh;">
                <div class="text-center mt-5">
                    <img class="d-block mx-auto mb-4" src="assets/img/icons/spot-illustrations/45.png" alt="shield" width="100" />
                    <h4>No news available</h4>
                    <p>Stay Tuned, we’re coming soon!</p>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-center">
                <a class="btn btn-sm btn-link d-block w-100 " href="app/social/followers.html">
                    View all
                    <span class="fas fa-chevron-right ms-1 fs--2"></span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection