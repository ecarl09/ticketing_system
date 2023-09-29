@extends('layouts.app')

@section('content')
    <div class="col-md-6 col-lg-6">
        <!-- Start Auth Box -->
        <div class="auth-box-right">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <div class="form-head">
                            <a href="index.html" class="logo"><img src="{{asset('assets/images/logo.svg')}}" class="img-fluid" alt="logo"></a>
                        </div> 

                        <h4 class="text-primary my-4">{{ __('Reset Password') }}</h4>

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group text-left">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email') <span class="invalid-feedback" role="alert">  <strong>{{ $message }}</strong>  </span> @enderror
                        </div>

                        <div class="form-group text-left">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>

                        <div class="form-group text-left">
                            <label for="password_confirmation">{{ __('Password Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" onmouseup="this.form.submit(); this.disabled=true; this.className='btn btn-secondary'; this.innerHTML='Loading . . .'; ">
                            {{ __('Reset Password') }}
                        </button>
                        
                    </form>
                    <p class="mb-0 mt-3">Remember Password? <a href="{{ route('login')}}">Log in</a></p>
                </div>
            </div>
        </div>
        <!-- End Auth Box -->
    </div>
@endsection
