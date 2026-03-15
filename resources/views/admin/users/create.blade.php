@extends('layouts.dashboard')
@section('title', 'Créer un Utilisateur')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="color: var(--color-muted); font-size: 13px; font-weight: 600;">
        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="card-5psl" style="max-width: 600px;">
    <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 24px;"><i class="fas fa-user-plus text-blue me-2"></i>Créer un nouvel utilisateur</h4>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Nom complet</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required style="font-size: 14px;">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Adresse Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required style="font-size: 14px;">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Rôle</label>
            <select name="role" class="form-select" style="font-size: 14px;" required>
                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Membre (Par défaut)</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
            </select>
            <div class="form-text" style="font-size: 11px;">Les administrateurs ont accès à la gestion du club, des membres et des transactions.</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Mot de passe</label>
            <input type="password" name="password" class="form-control" required style="font-size: 14px;">
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold" style="font-size: 13px;">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required style="font-size: 14px;">
        </div>

        <button type="submit" class="btn-possible w-100"><i class="fas fa-plus-circle me-2"></i> Créer le compte</button>
    </form>
</div>

@endsection
