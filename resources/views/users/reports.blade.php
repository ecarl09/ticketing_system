@extends('layouts.UsersMainLayouts')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endpush

@section('current-page-title')
    Reports
@endsection
@section('current-page-title-icon')
    fas fa-ticket-alt
@endsection

@section('usersContent')
    <div class="row g-3 mb-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            {{-- <h5 class="mb-0">Reports Form</h5> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body bg-light border-top">
                    <form action="{{ route('generate.user.report') }}" id="registration" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg col-xxl-5">
                                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Generate Reports</h6>
                                <div class="row mt-2">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">From:</p>
                                    </div>
                                    <div class="col">
                                        <input type="date" class="form-control" id="from" name="from" value="{{ old('from') }}">
                                        <span class="text-danger">
                                            @error('from')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">To:</p>
                                    </div>
                                    <div class="col">
                                        <input type="date" class="form-control" id="to" name="to" value="{{ old('to') }}">
                                        <span class="text-danger">
                                            @error('to')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1"></p>
                                    </div>
                                    <div class="col">
                                        <div class="d-grid gap-2">
                                            <button class="btn btn-sm btn-primary" type="submit">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if (isset($results))

            <div class="d-flex mt-3">
                <span class="fa-stack me-2 ms-n1">
                    <svg class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                    </svg>
                    <svg class="svg-inline--fa fa-list fa-w-16 fa-inverse fa-stack-1x text-primary" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="" style="transform-origin: 0.5em 0.5em;"><g transform="translate(256 256)"><g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)"><path fill="currentColor" d="M80 368H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm0-320H16A16 16 0 0 0 0 64v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16V64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm416 176H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z" transform="translate(-256 -256)"></path></g></g></svg><!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-list" data-fa-transform="shrink-2"></i> Font Awesome fontawesome.com -->
                </span>
                <div class="col">
                    <h5 class="mb-0 text-primary position-relative">
                        <span class="bg-200 dark__bg-1100 pe-3">
                            @if (isset($results[0]->chapterName))
                                {{ $results[0]->chapterName }}
                            @else
                                ALL
                            @endif
                        </span>
                        <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h5>
                    <p class="mb-0">Ticket Starting {{ date('M j, Y', strtotime($from)) }} To: {{ date('M j, Y', strtotime($to)) }}</p>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card py-3 mb-1">
                    <div class="card-body py-2">
                        <div class="row g-0">
                            <div class="col-6 col-md-4 border-200 border-bottom border-end pb-2">
                                <h6 class="pb-1 text-700">Total Ticket</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($total))
                                        {{ $total }}
                                    @else
                                        0
                                    @endif 
                                </p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-2 ps-3">
                                <h6 class="pb-1 text-700">General Inquiry</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($categoryTotal[2]->total))
                                        {{ $categoryTotal[2]->total }}
                                    @else
                                        0
                                    @endif 
                                </p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-2 pt-4 pt-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">Implementation Support</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($categoryTotal[3]->total))
                                        {{ $categoryTotal[3]->total }}
                                    @else
                                        0
                                    @endif 
                                </p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-2 pb-md-0 ps-3 ps-md-0">
                                <h6 class="pb-1 text-700">Error Encounter</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($categoryTotal[1]->total))
                                        {{ $categoryTotal[1]->total }}
                                    @else
                                        0
                                    @endif   
                                </p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-2 pb-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">Change Request</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($categoryTotal[0]->total))
                                        {{ $categoryTotal[0]->total }}
                                    @else
                                        0
                                    @endif   
                                </p>
                            </div>
                            <div class="col-6 col-md-4 pb-0 pt-2 ps-3">
                                <h6 class="pb-1 text-700">Others</h6>
                                <p class="font-sans-serif lh-1 fs-2">
                                    @if (isset($categoryTotal[4]->total))
                                        {{ $categoryTotal[4]->total }}
                                    @else
                                        0
                                    @endif                                 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-12">
            <div class="card" id="customersTable" data-list='{"valueNames":["name","chapter","number","ticketType","dateCreated","status","priority"],"page":10,"pagination":true}'>
                <div class="card-header">
                    <div class="row flex-between-center">
                        <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                            <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Reports</h5>
                        </div>
                        <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                            @if (isset($results))
                                <a href="{{ route('export.users.tickets', ['from' => $from, 'to' => $to]) }}" target="_blank" class="btn btn-sm btn-primary me-1 mb-1">
                                    Export
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body p-1" style="min-height: 35vh">
                    @if (isset($results))
                        <div class="table-responsive scrollbar">
                            <table id="myTable" class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                                <thead class="bg-200 text-900">
                                    <tr>
                                        <th class="sort pe-1 align-middle white-space-nowrap">#</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="date">Date</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="Chapter">Chapter</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="User">User</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="Department">Department</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap" data-sort="Type">Type</th>
                                        <th class="sort pe-1 align-middle white-space-nowrap text-center" data-sort="status">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="table-orders-body">
                                    @php
                                        $ctr = 0;
                                    @endphp
                                    @foreach ($results as $results)
                                        <tr class="btn-reveal-trigger">
                                            <td class="align-middle white-space-nowrap py-2">{{ $ctr += 1 }}</td>
                                            <td class="date align-middle white-space-nowrap py-2">{{ date('M j, Y', strtotime($results->created_at)) }}</td>
                                            <td class="Chapter align-middle white-space-nowrap py-2">{{ $results->chapterName }}</td>
                                            <td class="User align-middle white-space-nowrap py-2">{{ $results->firstName . ' ' . $results->lastName }}</td>
                                            <td class="Department align-middle white-space-nowrap py-2">{{ $results->department }}</td>
                                            <td class="date align-middle white-space-nowrap py-2">{{ $results->ticket_type }}</td>
                                            <td class="Type align-middle white-space-nowrap py-2 text-center fs-0 white-space-nowrap">
                                                <span @class([
                                                    'badge',
                                                    'badge',
                                                    'rounded-pill',
                                                    'd-block',
                                                    $results->status == 'RESOLVED' ? 'badge-soft-success' : null,
                                                    $results->status == 'CLOSED' ? 'badge-soft-success' : null,
                                                    $results->status == 'ON HOLD' ? 'badge-soft-warning' : null,
                                                    $results->status == 'OPENED' ? 'badge-soft-primary' : null,
                                                    $results->status == 'AWAITING REPLY' ? 'badge-soft-info' : null,
                                                    $results->status == 'ACTION TAKEN' ? 'badge-soft-secondary' : null,
                                                ])>
                                                    {{ $results->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card-body text-center py-5">
                            <p class="lead mb-5">No reports were found!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script>
        $(document).ready( function () {
            var table = $('#myTable').DataTable();
        });
    </script>
@endpush
