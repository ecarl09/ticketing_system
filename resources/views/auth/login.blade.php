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
                                        Don't have an account?
                                        <br>
                                        <a class="text-decoration-underline link-light" href="{{route('register')}}">Get started!</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-center">
                                <div class="p-4 p-md-5 flex-grow-1">
                                    <div class="row flex-between-center">
                                        <div class="col-auto">
                                            <h3>Account Login</h3>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}" >
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autocomplete="email" autofocus />
                                            @error('email')<span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password" />
                                            @error('password')<span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                        </div>
                                        <div class="row flex-between-center">
                                            <div class="col-auto">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                                    <label class="form-check-label mb-0" for="remember">{{ __('Remember Me') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="fs--1" href="{{ route('password.request') }}" > Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Log in</button>
                                        </div>
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



