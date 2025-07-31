@extends('layouts.UsersMainLayouts')

@push('css')
<link href="{{asset('assets/datatable/dataTables.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@section('current-page-title') Ticket List @endsection
@section('current-page-title-icon') fas fa-ticket-alt @endsection

@section('usersContent')
<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card" id="customersTable" data-list='{"valueNames":["name","chapter","number","ticketType","dateCreated","status","priority"],"page":10,"pagination":true}'>
            <div class="card-header bg-light">
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                        <!-- <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Ticket List</h5> -->
                    </div>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="table-responsive">
                    <table id="myTable" class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="ticketCode">Code</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="ticketType">Ticket Type</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="department">Department</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="dateCreated">Date created</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="status">Status</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="priority">Priority</th>
                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($list as $data)
                                <tr class="btn-reveal-trigger">
                                    <td class="ticketType align-middle white-space-nowrap py-2">{{$data->ticket_code}}</td>
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
                                    <td class="ticketType align-middle white-space-nowrap py-2">{{$data->department}}</td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{date("M d Y, h:i A", strtotime($data->created_at))}}</td>
                                    <td class="status align-middle py-2">
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
                                        <a class="btn btn-primary btn-sm" href="{{ route('ticket.details', $data->id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach   
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer d-flex align-items-center justify-content-center">
                <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                <ul class="pagination mb-0"></ul>
                <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div> --}}
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script src="{{asset('assets/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/datatable/dataTables.min.js')}}"></script>

<script>
    $(document).ready( function () {
        var table = $('#myTable').DataTable({
            "order": [] 
        });

        // $('.status-dropdown').on('change', function(e){
        //     var status = $(this).val();
        //     $('.status-dropdown').val(status)
        //     table.column(7).search(status).draw();
        // })
    });
</script>
@endpush