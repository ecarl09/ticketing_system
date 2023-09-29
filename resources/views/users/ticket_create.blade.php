@extends('layouts.usersMainLayouts')

@section('current-page-title') Create Ticket @endsection
@section('current-page-title-icon') fas fa-ticket-alt @endsection

@section('usersContent')
<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Ticket Form</h5>
        </div>
        <div class="card-body bg-light">

            @if(session('saved') == 'true')
                <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
                    <p class="mb-0 flex-1">Ticket has been created!</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <h6 class="fs-0 text-primary">User Information:</h6>

            <div class="row mb-2">
                <div class="col-lg-2 ms-3">
                    <h6 class="mb-0">Chapter name:</h6> 
                </div>
                <div class="col-lg-9">
                    <p class="fs--1 mb-0">{{Auth::user()['chapterName']}}</p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-lg-2 ms-3">
                    <h6 class="mb-0">Customer name:</h6> 
                </div>
                <div class="col-lg-9">
                    <p class="fs--1 mb-0">{{ucwords(Auth::user()['firstName']).' '.ucwords(Auth::user()['lastName'])}}</p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-lg-2 ms-3">
                    <h6 class="mb-0">Email Address::</h6> 
                </div>
                <div class="col-lg-9">
                    <p class="fs--1 mb-0">{{Auth::user()['email']}}</p>
                </div>
            </div>

            <h6 class="fs-0 mt-3 mb-2 text-primary">Ticket Details:</h6>

            <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">
                <form action="{{ route('submit.create.ticket.form') }}" method="POST" id="ticketForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gx-2">
                        <div class="col-lg-8 mb-3">
                            <label class="form-label" for="ticketType-title">Topics</label>    
                            <select class="form-control" id="ticketType" name="ticketType" @error('ticketType'){{'isValid'}}@enderror >
                                <option value="" disabled selected>-</option>
                                <option @if(old('ticketType') == 'General Inquiry') selected @endif >General Inquiry</option>
                                <option @if(old('ticketType') == 'Implementation Support') selected @endif >Implementation Support</option>
                                <option @if(old('ticketType') == 'Error Encounter') selected @endif >Error Encounter</option>
                                <option @if(old('ticketType') == 'Change Request') selected @endif >Change Request</option>
                                <option @if(old('ticketType') == 'Others') selected @endif >Others</option>
                            </select>
                            <span class="text-danger">@error('ticketType'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-8 mb-3">
                            <label class="form-label" for="department">Department:</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="" disabled selected>-</option>
                                <option @if(old('department') == 'Laboratory') selected @endif >Laboratory</option>
                                <option @if(old('department') == 'Radiology') selected @endif >Radiology</option>
                                <option @if(old('department') == 'Pharmacy') selected @endif >Pharmacy</option>
                                <option @if(old('department') == 'ER') selected @endif >ER</option>
                                <option @if(old('department') == 'Nursing') selected @endif >Nursing</option>
                                <option @if(old('department') == 'Philhealth') selected @endif >Philhealth</option>
                                <option @if(old('department') == 'Admitting') selected @endif >Admitting</option>
                                <option @if(old('department') == 'Cashier') selected @endif >Cashier</option>
                                <option @if(old('department') == 'Billing') selected @endif >Billing</option>
                                <option @if(old('department') == 'Central Supply') selected @endif >Central Supply</option>
                                <option @if(old('department') == 'IT') selected @endif >IT</option>
                                <option @if(old('department') == 'Others') selected @endif >Others</option>
                            </select>
                            <span class="text-danger">@error('department'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-8 mb-3">
                            <label class="form-label" for="anydesk">Anydesk Id:</label>
                            <input class="form-control" type="name" name="anydesk" id="anydesk"  />
                            <span class="text-danger">@error('anydesk'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-8 mb-3">
                            <label class="form-label" for="anydesk">Narrative:</label>
                            <textarea class="tinymce d-none" name="narrative" id="narrative" ></textarea>
                            <span class="text-danger">@error('narrative'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-8 mb-3">
                            <div class="d-flex align-items-center mt-2 ">
                                <input class="form-control" id="file" name="file[]" type="file" multiple="multiple" accept="image/*" />
                            </div>
                        </div>
                    </div>    
                    <button type="submit" class="btn btn-primary pl-4 pr-4" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-secondary pl-4 pr-4 mt-4'; this.innerHTML='Submitting . . .'; ">Submit</button>      
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('javascript')

<script src="{{asset('assets/jquery.min.js')}}"></script>
<script src="{{asset('vendors/tinymce/tinymce.min.js')}}"></script>

<script>
    tinymce.init({
        selector: '#narrative',  // change this value according to your HTML
        resize: false,
        height: 300
    });
</script>
@endpush

