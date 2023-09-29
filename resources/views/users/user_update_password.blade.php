@extends('layouts.usersMainLayouts')

@section('current-page-title') Password @endsection
@section('current-page-title-icon') fas fa-lock @endsection

@section('usersContent')
<div class="col-lg-12">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Update Password</h5>
        </div>
        <div class="card-body bg-light">
            <div class="border rounded-1 position-relative bg-white dark__bg-1100 p-3">
                @if(session('notMatch') == 'true')    
                    <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
                        <div class="bg-warning me-3 icon-item"><span class="fas fa-exclamation-circle text-white fs-3"></span></div>
                        <p class="mb-0 flex-1">Old password doesn't match!</p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('updated') == 'true')    
                    <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                        <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
                        <p class="mb-0 flex-1">Your password has been updated!</p>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('users.update.password.submit') }}" id="update_user" method="POST">
                    @csrf
                    <div class="col-lg-6 mb-2">
                        <label class="form-label" for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="{{ old('currentPassword') }}" placeholder="Enter current password here">
                        <span class="text-danger">@error('currentPassword'){{$message}}@enderror</span>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label class="form-label" for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password here">
                        <span class="text-danger">@error('newPassword'){{$message}}@enderror</span>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <label class="form-label" for="confirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password">
                        <span class="text-danger">@error('confirmPassword'){{$message}}@enderror</span>
                    </div>

                    <button class="btn btn-primary mt-2" type="button" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-primary me-1 mb-1'; this.innerHTML='Updating . . .'; ">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection