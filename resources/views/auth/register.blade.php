@extends('layouts.app')

@section('content')
<main class="main" id="top">
    <div class="container" data-layout="container">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>
        <div class="row flex-center min-vh-100 py-6">
            <div class="col-sm-10 col-md-8 col-lg-8 col-xl-8 col-xxl-8">
                <a class="d-flex flex-center mb-4" href="../../../index.html">
                    <img class="me-2" src="assets/mmg-infinity-logo.png" alt="" width="58" />
                    <span class="font-sans-serif fw-bolder fs-5 d-inline-block">IT SUPPORT</span>
                </a>
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5>Register</h5>
                            </div>
                            <div class="col-auto fs--1 text-600">
                                <span class="mb-0 undefined">Have an account?</span> 
                                <span><a href="{{route('login')}}">Login</a></span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('register') }}" >
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" placeholder="Enter first name here">
                                    @error('firstName')<span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label" for="middleName">Middle Name</label>
                                    <input type="text" class="form-control @error('middleName') is-invalid @enderror" id="middleName" name="middleName" value="{{ old('middleName') }}" placeholder="Enter middle name here">
                                    @error('middleName')<span class="text-danger">{{ $message }}</span> @enderror
                                </div>    

                                <div class="col-md-4">
                                    <label class="form-label" for="lastName">Last Name</label>
                                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" placeholder="Enter last name here">
                                    @error('lastName')<span class="text-danger">{{ $message }}</span> @enderror
                                </div>  
                            </div>

                            <div class="row mt-2">
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
                                <div class="col-md-4">
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
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Enter user last name"  >
                                    <span class="text-danger">@error('address'){{$message}}@enderror</span>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="chapter">Chapter Name</label>
                                    <select class="form-select js-choice" id="chapter" name="chapter" size="1" data-options='{"removeItemButton":true, "placeholder":true, ":true}'  >
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
                                        <option @if(old('chapter') == 'HDU UBAY') selected @endif>HDU UBAY</option>
                                        <option @if(old('chapter') == 'HDU SAN NARCISO') selected @endif>HDU SAN NARCISO</option>
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
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email here">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="number">Mobile Number</label>
                                    <input id="number" type="number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{ old('number') }}" placeholder="Enter mobile here">
                                    @error('number') <span class="itext-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password here">
                                    @error('password')  <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="password_confirmation">Confrim Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Enter confirm password here">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
