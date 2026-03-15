@extends('layouts.auth')
@section('title', 'Connexion')

@section('content')
<div class="auth-split">
    {{-- Left panel: presentation --}}
    <div class="auth-left">
        <h1>Connect to<br>your portfolio.</h1>
    </div>

    {{-- Right panel: form --}}
    <div class="auth-right">
        <div class="auth-right-content">
            <h2 class="auth-heading">Log in</h2>
            <p class="auth-subheading">Enter your details to access your account.</p>

            @if($errors->any())
                <div class="alert-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Email Address</label>
                    <input type="email" name="email" class="form-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Password</label>
                    <input type="password" name="password" class="form-input @error('password') is-invalid @enderror"
                        required autocomplete="current-password">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 500; cursor: pointer;">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                            style="width: 18px; height: 18px; accent-color: var(--possible-blue);">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 13px;">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-possible">Log in</button>
            </form>

            <div style="margin-top: 32px; font-size: 14px; font-weight: 500;">
                Don't have an account? 
                <a href="{{ route('register') }}" class="auth-link">Sign up</a>
            </div>
        </div>
    </div>
</div>
@endsection
