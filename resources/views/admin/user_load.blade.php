@extends('layouts.adminMainLayouts')

@push('css')
    <!-- <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> -->
@endpush

@section('current-page-title') User List @endsection
@section('current-page-title-icon') fas fa-users @endsection

@section('adminContent')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card" id="customersTable" data-list='{"valueNames":["name","chapter","position","number","email","status"],"page":10,"pagination":true}'>
            <div class="card-header bg-light">
                <div class="row flex-between-center">
                    <div class="col-md-auto">

                    </div>
                    <div class="col-md-auto">

                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="chapter">Chapter</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="position">Position</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="number">Number</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">Email</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach($users as $data)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <a href="#!">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <img class="rounded-circle" src="{{asset('/storage/profile_picture').'/'.$data->profile_picture}}" alt="">
                                                </div>
                                                <div class="flex-1 ps-2">
                                                    <h5 class="mb-0 fs--1" style="text-transform: capitalize">{{ucwords($data['firstName']).' '.ucwords($data['lastName'])}}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{$data->chapterName}}</td>
                                    <td class="number align-middle white-space-nowrap py-2">{{$data->position}}</td>
                                    <td class="ticketType align-middle white-space-nowrap py-2">{{$data->number}}</td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{$data->email}}</td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{$data->userStatus}}</td>

                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <a class="btn btn-primary btn-sm" href="#!">View</a>
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
</div>
@endsection

@push('javascript')
    <!-- <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-table-datatable.js') }}"></script> -->
@endpush

