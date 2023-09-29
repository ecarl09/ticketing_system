@extends('layouts.app')

@section('content')
<main class="main" id="top" >
    <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
            <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                <img class="bg-auth-circle-shape" src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250">
                <img class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
                <div class="card overflow-hidden z-index-1">
                    <div class="card-body p-0">
                        <div class="row g-0 h-100">
                            <div class="col-md-5 text-center bg-card-gradient">
                                <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                    <div class="bg-holder bg-auth-card-shape" style="background-image:url(../../../assets/img/icons/spot-illustrations/half-circle.png);"></div>
                                    <!--/.bg-holder-->

                                    <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="#!">IT SUPPORT</a>
                                        <p class="opacity-75 text-white">
                                            Ticketing systems automatically organize and prioritize support requests in a central dashboard.
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                                    <p class="text-white">
                                        Already have an account?
                                        <br>
                                        <a class="text-decoration-underline link-light" href="{{route('login')}}">Login!</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-center">
                                <div class="p-4 p-md-5 flex-grow-1">
                                    <h3>Reset password</h3>
                                    <form action="{{ route('submit.reset.initial.password') }}" class="mt-3"" method="POST">
                                    @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="newPassword">New Password</label>
                                            <input class="form-control" type="password" id="newPassword" name="newPassword" value="{{ old('email') }}" />
                                            <span class="text-danger">@error('newPassword'){{$message}}@enderror</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="confirmPassword">Confirm Password</label>
                                            <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" />
                                            <span class="text-danger">@error('confirmPassword'){{$message}}@enderror</span>
                                        </div>
                                        <button class="btn btn-primary d-block w-100 mt-3" type="button" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-secondary d-block w-100 mt-3'; this.innerHTML='Updating . . .'; " >Set password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection



