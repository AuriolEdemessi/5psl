@extends('layouts.auth')
@section('title', 'Vérification Email')

@section('content')
<div class="auth-split">
    {{-- Left panel: presentation --}}
    <div class="auth-left">
        <h1>Secure your<br>account with<br>5PSL.</h1>
    </div>

    {{-- Right panel: form --}}
    <div class="auth-right">
        <div class="auth-right-content">
            <h2 class="auth-heading">Verify your email</h2>
            <p class="auth-subheading">We sent a verification link to your email address. Please click the link to activate your account.</p>

            @if (session('resent'))
                <div class="alert-box" style="background-color: #e0f2fe; color: #0066ff; border: none;">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            @endif

            <p style="color: #64748b; font-size: 14px; margin-bottom: 24px;">
                Didn't receive the email?
            </p>

            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}" style="margin-bottom: 24px;">
                @csrf
                <button type="submit" class="btn-possible">Resend verification link</button>
            </form>

            <div style="margin-top: 32px; font-size: 14px; font-weight: 500; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 24px;">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" style="background:none; border:none; color: #64748b; font-size: 14px; cursor: pointer; text-decoration: underline;">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
