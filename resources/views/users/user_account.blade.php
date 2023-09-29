@extends('layouts.usersMainLayouts')

@section('current-page-title') User Account @endsection
@section('current-page-title-icon') far fa-user @endsection

@section('usersContent')
<div class="row">
    <div class="col-12">
        <div class="card mb-3 btn-reveal-trigger">
            <div class="card-header position-relative min-vh-25 mb-8">
                <div class="cover-image">
                    <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(../../assets/img/generic/4.jpg);"></div>
                    <!--/.bg-holder-->
                    <input class="d-none" id="upload-cover-image" type="file" />
                    <label class="cover-image-file-input" for="upload-cover-image">
                        <span class="fas fa-camera me-2"></span>
                        <span>Change cover photo</span>
                    </label>
                </div>
                <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                    <form action="{{ route('upload.user.profile') }}" method="POST" enctype="multipart/form-data" id="uploadImage">
                        @csrf
                        <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> 
                            <img src="{{asset('/storage/profile_picture/'.$user['profile_picture'])}}" width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                            <input class="d-none" id="profile-image" type="file" accept="image/*" name="file"  />
                            <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                                <span class="bg-holder overlay overlay-0"></span>
                                <span class="z-index-1 text-white dark__text-white text-center fs--1">
                                    <span class="fas fa-camera"></span>
                                    <span class="d-block">Update</span>
                                </span>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Profile Settings</h5>
            </div>
            <div class="card-body bg-light">
                <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">

                    @if(session('updated') == 'true')
                        <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                            <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">Your account has been updated!</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="row g-3" action="{{ route('users.update.account.submit') }}" id="update_user" method="POST">
                    @csrf
                        <div class="col-lg-4">
                            <label class="form-label" for="firstName">First Name</label>
                            <input type="name" class="form-control" id="firstName" name="firstName" value="{{ $user['firstName'] }}" placeholder="Enter user first name" >
                            <span class="text-danger">@error('firstName'){{$message}}@enderror</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label" for="middleName">Middle Name</label>
                            <input type="name" class="form-control" id="middleName" name="middleName" value="{{ $user['middleName'] }}"  placeholder="Enter user middle name" >
                            <span class="text-danger">@error('middleName'){{$message}}@enderror</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label" for="lastName">Last Name</label>
                            <input type="name" class="form-control" id="lastName" name="lastName" value="{{ $user['lastName'] }}" placeholder="Enter user last name" >
                            <span class="text-danger">@error('lastName'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="gender">Gender</label>
                            <select class="form-control" id="gender" name="gender" >
                                <option selected disabled> - </option>
                                <option @if($user['gender'] == 'Male') selected @endif >Male</option>
                                <option @if($user['gender'] == 'Female') selected @endif>Female</option>
                            </select>
                            <span class="text-danger">@error('gender'){{$message}}@enderror</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label" for="birthday">Birthday</label>
                            <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $user['birthday'] }}" >
                            <span class="text-danger">@error('birthday'){{$message}}@enderror</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label" for="civilStatus">Civil Status</label>
                            <select class="form-control" id="civilStatus" name="civilStatus" >
                                <option value="" disabled="" selected="">Select a status...</option>                                                             
                                <option @if($user['civilStatus'] == 'Single') selected @endif>Single</option>
                                <option @if($user['civilStatus'] == 'Married') selected @endif>Married</option>
                                <option @if($user['civilStatus'] == 'Widowed') selected @endif>Widowed</option>
                                <option @if($user['civilStatus'] == 'Divorced') selected @endif>Divorced</option>
                            </select>
                            <span class="text-danger">@error('civilStatus'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label" for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $user['address'] }}" placeholder="Enter user last name" >
                            <span class="text-danger">@error('address'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="chapter">Chapter Name</label>
                            <select class="form-control" id="chapter" name="chapter" >
                                <option value="" disabled="" selected="">Select a Chapter...</option> 
                                <option @if($user['chapterName'] == 'BUPHARCO') selected @endif>BUPHARCO</option>
                                <option @if($user['chapterName'] == 'MAHESECO') selected @endif>MAHESECO</option>
                                <option @if($user['chapterName'] == 'MCDC') selected @endif>MCDC</option>
                                <option @if($user['chapterName'] == 'MMG Aklan') selected @endif>MMG Aklan</option>
                                <option @if($user['chapterName'] == 'MMG Aklan Specialty Clinic') selected @endif>MMG Aklan Specialty Clinic</option>
                                <option @if($user['chapterName'] == 'MMG Albay') selected @endif>MMG Albay</option>
                                <option @if($user['chapterName'] == 'MMG Bislig') selected @endif>MMG Bislig</option>
                                <option @if($user['chapterName'] == 'MMG Bohol') selected @endif>MMG Bohol</option>
                                <option @if($user['chapterName'] == 'MMG Bulacan') selected @endif>MMG Bulacan</option>
                                <option @if($user['chapterName'] == 'MMG Calapan') selected @endif>MMG Calapan</option>
                                <option @if($user['chapterName'] == 'MMG CamSur') selected @endif>MMG CamSur</option>
                                <option @if($user['chapterName'] == 'MMG Davao') selected @endif>MMG Davao</option>
                                <option @if($user['chapterName'] == 'MMG Dipolog') selected @endif>MMG Dipolog</option>
                                <option @if($user['chapterName'] == 'MMG Federation') selected @endif>MMG Federation</option>
                                <option @if($user['chapterName'] == 'MMG GenSan') selected @endif>MMG GenSan</option>
                                <option @if($user['chapterName'] == 'MMG Masbate') selected @endif>MMG Masbate</option>
                                <option @if($user['chapterName'] == 'MMG Metro Rizal') selected @endif>MMG Metro Rizal</option>
                                <option @if($user['chapterName'] == 'MMG Palawan') selected @endif>MMG Palawan</option>
                                <option @if($user['chapterName'] == 'MMG Pasig') selected @endif>MMG Pasig</option>
                                <option @if($user['chapterName'] == 'MMG Qatar') selected @endif>MMG Qatar</option>
                                <option @if($user['chapterName'] == 'MMG Quezon') selected @endif>MMG Quezon</option>
                                <option @if($user['chapterName'] == 'MMG Sorsogon') selected @endif>MMG Sorsogon</option>
                                <option @if($user['chapterName'] == 'MMG Tacurong') selected @endif>MMG Tacurong</option>
                                <option @if($user['chapterName'] == 'MMG Tagum') selected @endif>MMG Tagum</option>
                                <option @if($user['chapterName'] == 'MMG Zambales') selected @endif>MMG Zambales</option>
                                <option @if($user['chapterName'] == 'PMPC') selected @endif>PMPC</option>  
                            </select>
                            <span class="text-danger">@error('chapter'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="position">Position</label>
                            <select class="form-control" id="position" name="position" >
                                <option value="" disabled="" selected="">Select a position...</option>                                                                                                                          
                                <option @if($user['position']  == 'Accountant') selected @endif>Accountant</option>
                                <option @if($user['position']  == 'Administrative Officer') selected @endif>Administrative Officer</option>
                                <option @if($user['position']  == 'Admission Section Officer') selected @endif>Admission Section Officer</option>
                                <option @if($user['position']  == 'Assistant Pharmacist') selected @endif>Assistant Pharmacist</option>
                                <option @if($user['position']  == 'Auditor') selected @endif>Auditor</option>
                                <option @if($user['position']  == 'BOD Chairman') selected @endif>BOD Chairman</option>
                                <option @if($user['position']  == 'BOD Member') selected @endif>BOD Member</option>
                                <option @if($user['position']  == 'BOD Secretary') selected @endif>BOD Secretary</option>
                                <option @if($user['position']  == 'Bookkeeper') selected @endif>Bookkeeper</option>
                                <option @if($user['position']  == 'CEO') selected @endif>CEO</option>
                                <option @if($user['position']  == 'Cashier') selected @endif>Cashier</option>
                                <option @if($user['position']  == 'Chief Nurse') selected @endif>Chief Nurse</option>
                                <option @if($user['position']  == 'Chief Operating Officer') selected @endif>Chief Operating Officer</option>
                                <option @if($user['position']  == 'Consultant') selected @endif>Consultant</option>
                                <option @if($user['position']  == 'Doctor') selected @endif>Doctor</option>
                                <option @if($user['position']  == 'Employee') selected @endif>Employee</option>
                                <option @if($user['position']  == 'HR Officer') selected @endif>HR Officer</option>
                                <option @if($user['position']  == 'IT') selected @endif>IT</option>
                                <option @if($user['position']  == 'Inventory Section Officer') selected @endif>Inventory Section Officer</option>
                                <option @if($user['position']  == 'Medical Director') selected @endif>Medical Director</option>
                                <option @if($user['position']  == 'Medical Technologist') selected @endif>Medical Technologist</option>
                                <option @if($user['position']  == 'Nurse') selected @endif>Nurse</option>
                                <option @if($user['position']  == 'Pharmacist') selected @endif>Pharmacist</option>
                                <option @if($user['position']  == 'Project Manager') selected @endif>Project Manager</option>
                                <option @if($user['position']  == 'Radiologic Technologist') selected @endif>Radiologic Technologist</option>
                                <option @if($user['position']  == 'Records Section Officer') selected @endif>Records Section Officer</option>
                                <option @if($user['position']  == 'Treasurer') selected @endif>Treasurer</option>                                                                                                               
                            </select>
                            <span class="text-danger">@error('position'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label" for="contactNumber">Contact Number</label>
                            <input type="number" class="form-control" id="contactNumber" name="contactNumber" value="{{ $user['number'] }}" placeholder="Enter user mobile number" >
                            <span class="text-danger">@error('contactNumber'){{$message}}@enderror</span>
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user['email'] }}" placeholder="Enter user email" >
                            <span class="text-danger">@error('email'){{$message}}@enderror</span>
                        </div>

                        <div class="col-12 ">
                            <button type="button" class="btn btn-primary" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-primary'; this.innerHTML='Updating . . .'; ">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script src="{{asset('assets/jquery.min.js')}}"></script>

<script>
$( document ).ready(function() {
    $('#profile-image').on('change', function() {
        $('#uploadImage').submit();
    });
});
</script>
@endpush