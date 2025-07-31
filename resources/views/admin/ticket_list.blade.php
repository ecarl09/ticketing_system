@extends('layouts.adminMainLayouts')

@push('css')
<link href="{{ asset('assets/datatable/dataTables.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
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
                        <div class="d-flex justify-content-end gap-2">
                            <select class="form-select form-select-sm status-dropdown" id="filterChapter">
                                <option value="" selected disabled>FILTER CHAPTER</option>
                                <option value="">ALL</option>
                                @foreach($chapterName as $chapterName)
                                    <option value="{{ $chapterName }}">{{ $chapterName }}</option>
                                @endforeach
                            </select>

                            <select class="form-select form-select-sm status-dropdown" id="filterStatus">
                                <option value="" selected disabled>FILTER STATUS</option>
                                <option value="">ALL</option>
                                @foreach(['NEW', 'OPENED', 'ACTION TAKEN', 'AWAITING REPLY', 'ON HOLD'] as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-1">
                <div class="table-responsive">
                    <table id="myTable" class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th data-sort="name">Name</th>
                                <th data-sort="name">Code</th>
                                <th data-sort="chapter">Chapter</th>
                                <th data-sort="number">Number</th>
                                <th data-sort="ticketType">Type</th>
                                <th data-sort="dateCreated">Date</th>
                                <th data-sort="dateCreated">Time</th>
                                <th data-sort="status">Status</th>
                                <th data-sort="priority">Priority</th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @php
                                $typeColors = [
                                    'General Inquiry' => 'primary',
                                    'Implementation Support' => 'success',
                                    'Error Encounter' => 'danger',
                                    'Change Request' => 'warning',
                                    'Others' => 'secondary',
                                ];

                                $statusColors = [
                                    'NEW' => 'secondary',
                                    'OPENED' => 'primary',
                                    'ACTION TAKEN' => 'warning',
                                    'AWAITING REPLY' => 'info',
                                    'ON HOLD' => 'danger',
                                    'RESOLVED' => 'success',
                                    'CLOSED' => 'success',
                                ];

                                $priorityColors = [
                                    'NORMAL' => 'primary',
                                    'MEDIUM' => 'warning',
                                    'URGENT' => 'danger',
                                ];
                            @endphp

                            @foreach($list as $data)
                                <tr class="btn-reveal-trigger">
                                    <td class="name align-middle white-space-nowrap py-2">
                                        <a href="#!">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <img class="rounded-circle" src="{{ asset('storage/app/public/profile_picture/'.$data->profile_picture) }}" alt="">
                                                </div>
                                                <div class="flex-1 ps-2">
                                                    <h5 class="mb-0 fs--1 text-capitalize">{{ $data->firstName }}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{ $data->ticket_code }}</td>
                                    <td class="chapter align-middle white-space-nowrap py-2">{{ $data->chapterName }}</td>
                                    <td class="number align-middle white-space-nowrap py-2">{{ $data->number }}</td>
                                    <td class="ticketType align-middle white-space-nowrap py-2">
                                        <span class="badge bg-{{ $typeColors[$data->ticket_type] ?? 'secondary' }}">{{ $data->ticket_type }}</span>
                                    </td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{ \Carbon\Carbon::parse($data->created_at)->format('M d, Y') }}</td>
                                    <td class="dateCreated align-middle white-space-nowrap py-2">{{ \Carbon\Carbon::parse($data->created_at)->format('h:i A') }}</td>
                                    <td class="status align-middle white-space-nowrap py-2">
                                        <span class="badge bg-{{ $statusColors[$data->status] ?? 'secondary' }}">{{ $data->status }}</span>
                                    </td>
                                    <td class="priority align-middle white-space-nowrap py-2">
                                        <span class="badge bg-{{ $priorityColors[$data->priority] ?? 'secondary' }}">{{ $data->priority }}</span>
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
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/datatable/dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        const table = $('#myTable').DataTable({ order: [] });

        $('#filterChapter').on('change', function () {
            const value = $(this).val();
            table.column(2).search(value).draw();
        });

        $('#filterStatus').on('change', function () {
            const status = $(this).val();
            table.column(7).search(value).draw();
        });
    });
</script>
@endpush
