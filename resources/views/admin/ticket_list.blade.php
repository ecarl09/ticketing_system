@extends('layouts.adminMainLayouts')

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
@endpush

@section('current-page-title') Ticket List @endsection
@section('current-page-title-icon') fas fa-ticket-alt @endsection

@section('adminContent')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card" id="customersTable" data-list='{"valueNames":["name","chapter","number","ticketType","dateCreated","status","priority"],"page":10,"pagination":true}'>
            <div class="card-header bg-light">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Ticket List</h5>
                    </div>

                    <div class="col-8 col-sm-auto ms-auto text-end ps-0">
                        <select class="form-select form-select-sm status-dropdown" >
                            <option value="" selected disabled >FILTER STATUS</option>
                            <option value="">ALl</option>
                            <option value="NEW">NEW</option>
                            <option value="OPENED">OPENED</option>
                            <option value="ACTION TAKEN">ACTION TAKEN</option>
                            <option value="AWAITING REPLY">AWAITING REPLY</option>
                            <option value="ON HOLD">ON HOLD</option>
                            <option value="RESOLVED">RESOLVED</option>
                            <option value="CLOSED">CLOSED</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="table-responsive">
                    <table id="myTable" class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Name</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">Code</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="chapter">Chapter</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="number">Number</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="ticketType">Type</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="dateCreated">Date</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="dateCreated">Time</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="priority">Priority</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($list as $data)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <a href="#!">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <img class="rounded-circle" src="{{asset('/storage/app/public/profile_picture/'.$data->profile_picture)}}" alt="">
                                                </div>
                                                <div class="flex-1 ps-2">
                                                    <h5 class="mb-0 fs--1" style="text-transform: capitalize">{{$data->firstName}}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{$data->ticket_code}}</td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{$data->chapterName}}</td>
                                    <td class="number align-middle white-space-nowrap py-2">{{$data->number}}</td>
                                    <td class="ticketType align-middle white-space-nowrap py-2">                              
                                        @if($data->ticket_type == 'General Inquiry')
                                            <span class="badge bg-primary">{{ $data->ticket_type }}</span>
                                        @elseif($data->ticket_type == 'Implementation Support')
                                            <span class="badge bg-success">{{ $data->ticket_type }}</span>
                                        @elseif($data->ticket_type == 'Error Encounter')
                                            <span class="badge bg-danger">{{ $data->ticket_type }}</span>
                                        @elseif($data->ticket_type == 'Change Request')
                                            <span class="badge bg-warning">{{ $data->ticket_type }}</span>
                                        @elseif($data->ticket_type == 'Others')
                                            <span class="badge bg-secondary">{{ $data->ticket_type }}</span>
                                        @endif
                                    </td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{date("M d, Y", strtotime($data->created_at))}}</td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{date("h:i A", strtotime($data->created_at))}}</td>
                                    <td class="status align-middle white-space-nowrap py-2">
                                        @if($data->status == 'NEW')
                                            <span class="badge bg-secondary">{{ $data->status }}</span>
                                        @elseif($data->status == 'OPENED')
                                            <span class="badge bg-primary">{{ $data->status }}</span>
                                        @elseif($data->status == 'ACTION TAKEN')
                                            <span class="badge bg-warning">{{ $data->status }}</span>
                                        @elseif($data->status == 'AWAITING REPLY')
                                            <span class="badge bg-info">{{ $data->status }}</span>
                                        @elseif($data->status == 'ON HOLD')
                                            <span class="badge bg-danger">{{ $data->status }}</span>
                                        @elseif($data->status == 'RESOLVED')
                                            <span class="badge bg-success">{{ $data->status }}</span>
                                        @elseif($data->status == 'CLOSED')
                                            <span class="badge bg-success">{{ $data->status }}</span>
                                        @endif
                                    </td>
                                    <td class="priority align-middle white-space-nowrap py-2">
                                        @if($data->priority == 'NORMAL')
                                            <span class="badge bg-primary">{{ $data->priority }}</span>
                                        @elseif($data->priority == 'MEDIUM')
                                            <span class="badge bg-warning">{{ $data->priority }}</span>
                                        @elseif($data->priority == 'URGENT')
                                            <span class="badge bg-danger">{{ $data->priority }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <a class="btn btn-primary btn-sm" href="{{ route('admin.ticket.details', [$data->id, $data->status]) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<script>
    $(document).ready( function () {
        var table = $('#myTable').DataTable({
            "order": [] 
        });

        $('.status-dropdown').on('change', function(e){
            var status = $(this).val();
            $('.status-dropdown').val(status)
            table.column(7).search(status).draw();
        })
    });
</script>
@endpush