@extends('layouts.adminMainLayouts')

@section('current-page-title') Users Registration Form  @endsection
@section('current-page-title-icon') fas fa-users @endsection

@push('css')
<link href="{{asset('vendors/choices/choices.min.css')}}" rel="stylesheet" />
@endpush

@section('adminContent')
<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Add User Form</h5>
        </div>
        <div class="card-body bg-light">
            <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">
                @if(session('saved') == 'true')
                    <div class="alert-list mt-3">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Success!</h4>
                            <p>New user has been saved successfully</p>
                        </div>                                    
                    </div>
                @endif

                @if(session('existing') == 'true')
                    <div class="alert-list mt-3">
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Failed!</h4>
                            <p>Email address already exist!</p>
                        </div>                                    
                    </div>
                @endif

                <form action="{{ route('submit.registration.form') }}" id="registration" method="POST" >
                    @csrf
                    <div class="col mt-3 mb-3">
                        <h5 class="mb-0 text-primary position-relative">
                            <span class="bg-white pe-3">Basic Information</span>
                            <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                        </h5>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="firstName">First Name</label>
                            <input class="form-control" type="name" id="firstName" name="firstName" value="{{ old('firstName') }}" placeholder="Enter user first name" />
                            <span class="text-danger">@error('firstName'){{$message}}@enderror</span>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="firstName">Middle Name</label>
                            <input class="form-control" type="name" id="middleName" name="middleName" value="{{ old('middleName') }}" placeholder="Enter user middle name" />
                            <span class="text-danger">@error('middleName'){{$message}}@enderror</span>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="lastName">Last Name</label>
                            <input class="form-control" type="name" id="lastName" name="lastName" value="{{ old('lastName') }}" placeholder="Enter user last name" />
                            <span class="text-danger">@error('lastName'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-4">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" >
                                <option selected disabled value="">Select Gender ... </option>
                                <option @if(old('gender') == 'Male') selected @endif >Male</option>
                                <option @if(old('gender') == 'Female') selected @endif>Female</option>
                            </select>
                            <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                        </div>
                        <div class=" col-md-4">
                            <label class="form-label" for="birthday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}" >
                            <span class="text-danger">@error('birthday'){{$message}}@enderror</span>
                        </div>
                        <div class=" col-md-4">
                            <label class="form-label" for="civilStatus">Civil Status</label>
                            <select class="form-control" id="civilStatus" name="civilStatus" >
                                <option value="" disabled="" selected="">Select a status...</option>                                                             
                                    <option @if(old('civilStatus') == 'Single') selected @endif>Single</option>
                                    <option @if(old('civilStatus') == 'Married') selected @endif>Married</option>
                                    <option @if(old('civilStatus') == 'Widowed') selected @endif>Widowed</option>
                                    <option @if(old('civilStatus') == 'Divorced') selected @endif>Divorced</option>
                                </select>
                                <span class="text-danger">@error('civilStatus'){{$message}}@enderror</span>
                            </select>
                        </div>

                        <div class="mb-3 mt-3 col-md-12">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Enter user last name"  >
                            <span class="text-danger">@error('address'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <div class="col mt-3 mb-3">
                        <h5 class="mb-0 text-primary position-relative">
                            <span class="bg-white pe-3">Chapter Details</span>
                            <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                        </h5>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="chapter">Chapter Name</label>
                            <select class="form-select js-choice" id="chapter" name="chapter" size="1" data-options='{"removeItemButton":true, "placeholder":true, "required":true}'  >
                                <option value="" disabled="" selected="">Select a Chapter...</option> 
                                <option @if(old('chapter') == 'BUPHARCO') selected @endif>BUPHARCO</option>
                                <option @if(old('chapter') == 'MAHESECO') selected @endif>MAHESECO</option>
                                <option @if(old('chapter') == 'MCDC') selected @endif>MCDC</option>
                                <option @if(old('chapter') == 'MMG Aklan') selected @endif>MMG Aklan</option>
                                <option @if(old('chapter') == 'MMG Aklan Specialty Clinic') selected @endif>MMG Aklan Specialty Clinic</option>
                                <option @if(old('chapter') == 'MMG Albay') selected @endif>MMG Albay</option>
                                <option @if(old('chapter') == 'MMG Bislig') selected @endif>MMG Bislig</option>
                                <option @if(old('chapter') == 'MMG Bohol') selected @endif>MMG Bohol</option>
                                <option @if(old('chapter') == 'MMG Bulacan') selected @endif>MMG Bulacan</option>
                                <option @if(old('chapter') == 'MMG Calapan') selected @endif>MMG Calapan</option>
                                <option @if(old('chapter') == 'MMG CamSur') selected @endif>MMG CamSur</option>
                                <option @if(old('chapter') == 'MMG Davao') selected @endif>MMG Davao</option>
                                <option @if(old('chapter') == 'MMG Dipolog') selected @endif>MMG Dipolog</option>
                                <option @if(old('chapter') == 'MMG Federation') selected @endif>MMG Federation</option>
                                <option @if(old('chapter') == 'MMG GenSan') selected @endif>MMG GenSan</option>
                                <option @if(old('chapter') == 'MMG Masbate') selected @endif>MMG Masbate</option>
                                <option @if(old('chapter') == 'MMG Metro Rizal') selected @endif>MMG Metro Rizal</option>
                                <option @if(old('chapter') == 'MMG Palawan') selected @endif>MMG Palawan</option>
                                <option @if(old('chapter') == 'MMG Pasig') selected @endif>MMG Pasig</option>
                                <option @if(old('chapter') == 'MMG Qatar') selected @endif>MMG Qatar</option>
                                <option @if(old('chapter') == 'MMG Quezon') selected @endif>MMG Quezon</option>
                                <option @if(old('chapter') == 'MMG Sorsogon') selected @endif>MMG Sorsogon</option>
                                <option @if(old('chapter') == 'MMG Tacurong') selected @endif>MMG Tacurong</option>
                                <option @if(old('chapter') == 'MMG Tagum') selected @endif>MMG Tagum</option>
                                <option @if(old('chapter') == 'MMG Zambales') selected @endif>MMG Zambales</option>
                                <option @if(old('chapter') == 'PMPC') selected @endif>PMPC</option>  
                            </select>
                            <span class="text-danger">@error('chapter'){{$message}}@enderror</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="position">Position</label>
                            <select class="form-select js-choice" id="position" name="position" size="1" data-options='{"removeItemButton":true,"placeholder":true}' >
                                <option value="" disabled="" selected="">Select a position...</option>                                                                                                                          
                                <option @if(old('chapter') == 'Accountant') selected @endif>Accountant</option>
                                <option @if(old('chapter') == 'Administrative Officer') selected @endif>Administrative Officer</option>
                                <option @if(old('chapter') == 'Admission Section Officer') selected @endif>Admission Section Officer</option>
                                <option @if(old('chapter') == 'Assistant Pharmacist') selected @endif>Assistant Pharmacist</option>
                                <option @if(old('chapter') == 'Auditor') selected @endif>Auditor</option>
                                <option @if(old('chapter') == 'BOD Chairman') selected @endif>BOD Chairman</option>
                                <option @if(old('chapter') == 'BOD Member') selected @endif>BOD Member</option>
                                <option @if(old('chapter') == 'BOD Secretary') selected @endif>BOD Secretary</option>
                                <option @if(old('chapter') == 'Bookkeeper') selected @endif>Bookkeeper</option>
                                <option @if(old('chapter') == 'CEO') selected @endif>CEO</option>
                                <option @if(old('chapter') == 'Cashier') selected @endif>Cashier</option>
                                <option @if(old('chapter') == 'Chief Nurse') selected @endif>Chief Nurse</option>
                                <option @if(old('chapter') == 'Chief Operating Officer') selected @endif>Chief Operating Officer</option>
                                <option @if(old('chapter') == 'Consultant') selected @endif>Consultant</option>
                                <option @if(old('chapter') == 'Doctor') selected @endif>Doctor</option>
                                <option @if(old('chapter') == 'Employee') selected @endif>Employee</option>
                                <option @if(old('chapter') == 'HR Officer') selected @endif>HR Officer</option>
                                <option @if(old('chapter') == 'IT') selected @endif>IT</option>
                                <option @if(old('chapter') == 'Inventory Section Officer') selected @endif>Inventory Section Officer</option>
                                <option @if(old('chapter') == 'Medical Director') selected @endif>Medical Director</option>
                                <option @if(old('chapter') == 'Medical Technologist') selected @endif>Medical Technologist</option>
                                <option @if(old('chapter') == 'Nurse') selected @endif>Nurse</option>
                                <option @if(old('chapter') == 'Pharmacist') selected @endif>Pharmacist</option>
                                <option @if(old('chapter') == 'Project Manager') selected @endif>Project Manager</option>
                                <option @if(old('chapter') == 'Radiologic Technologist') selected @endif>Radiologic Technologist</option>
                                <option @if(old('chapter') == 'Records Section Officer') selected @endif>Records Section Officer</option>
                                <option @if(old('chapter') == 'Treasurer') selected @endif>Treasurer</option>                                                                                                               
                            </select>
                            <span class="text-danger">@error('position'){{$message}}@enderror</span>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="contactNumber">Contact Number</label>
                            <input type="number" class="form-control" id="contactNumber" name="contactNumber" value="{{ old('contactNumber') }}" placeholder="Enter user mobile number" >
                            <span class="text-danger">@error('contactNumber'){{$message}}@enderror</span>
                        </div>
                    </div>

                    <div class="col mt-3 mb-3">
                        <h5 class="mb-0 text-primary position-relative">
                            <span class="bg-white pe-3">Account Setting</span>
                            <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                        </h5>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter user email" >
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"  placeholder="Enter user password" >
                            <span class="text-danger">@error('password'){{$message}}@enderror</span>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="userType">User Type</label>
                            <select class="form-control" id="userType" name="userType" >
                                <option selected disabled value="">Choose  ...</option>
                                <option @if(old('userType') == '0') selected @endif value="0">Admin</option>
                                <option @if(old('userType') == '1') selected @endif value="1">Chapter</option>
                            </select>
                            <span class="text-danger">@error('userType'){{$message}}@enderror</span>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="button" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-secondary pl-4 pr-4'; this.innerHTML='Loading . . .'; ">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
@endpush