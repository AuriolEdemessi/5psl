@extends('layouts.auth')
@section('title', 'Inscription')

@section('content')
<div class="auth-split">
    {{-- Left panel: presentation --}}
    <div class="auth-left">
        <h1>Start building<br>wealth<br>with 5PSL.</h1>
    </div>

    {{-- Right panel: form --}}
    <div class="auth-right">
        <div class="auth-right-content">
            <h2 class="auth-heading">Sign up</h2>
            <p class="auth-subheading">Create your account to start investing.</p>

            @if($errors->any())
                <div class="alert-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Full Name</label>
                    <input type="text" name="name" class="form-input @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Email Address</label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autocomplete="email">
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Password</label>
                    <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                        required autocomplete="new-password">
                </div>

                <div style="margin-bottom: 32px;">
                    <label class="form-label-custom">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input"
                        required autocomplete="new-password">
                </div>

                <button type="submit" class="btn-possible">Create account</button>
            </form>

            <div style="margin-top: 32px; font-size: 14px; font-weight: 500;">
                Already have an account? 
                <a href="{{ route('login') }}" class="auth-link">Log in</a>
            </div>
        </div>
    </div>
</div>
@endsection
