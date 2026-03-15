@extends('layouts.dashboard')
@section('title', 'Éditer un Utilisateur')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="text-decoration-none" style="color: var(--color-muted); font-size: 13px; font-weight: 600;">
        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="card-5psl" style="max-width: 600px;">
    <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 24px;"><i class="fas fa-user-edit text-blue me-2"></i>Éditer l'utilisateur</h4>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Nom complet</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required style="font-size: 14px;">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Adresse Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required style="font-size: 14px;">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold" style="font-size: 13px;">Rôle</label>
                <select name="role" class="form-select" style="font-size: 14px;" required>
                    <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Membre</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    @if(Auth::user()->role === 'superadmin' || $user->role === 'superadmin')
                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    @endif
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold" style="font-size: 13px;">Tier (Niveau)</label>
                <select name="tier" class="form-select" style="font-size: 14px;">
                    <option value="STARTER" {{ old('tier', $user->tier) == 'STARTER' ? 'selected' : '' }}>STARTER</option>
                    <option value="PRO" {{ old('tier', $user->tier) == 'PRO' ? 'selected' : '' }}>PRO</option>
                    <option value="ELITE" {{ old('tier', $user->tier) == 'ELITE' ? 'selected' : '' }}>ELITE</option>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold" style="font-size: 13px;">Statut KYC</label>
            <select name="kyc_status" class="form-select" style="font-size: 14px;" required>
                <option value="pending" {{ old('kyc_status', $user->kyc_status) == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="verified" {{ old('kyc_status', $user->kyc_status) == 'verified' ? 'selected' : '' }}>Vérifié</option>
                <option value="rejected" {{ old('kyc_status', $user->kyc_status) == 'rejected' ? 'selected' : '' }}>Rejeté</option>
            </select>
            <div class="form-text" style="font-size: 11px;">(Attention: le changement direct de KYC ici ne notifie pas le refus, utiliser la section KYC dédiée si possible).</div>
        </div>

        <hr style="border-color: #e2e8f0; margin: 24px 0;">
        <h5 style="font-size: 14px; font-weight: 800; margin-bottom: 16px;">Modifier le mot de passe (Optionnel)</h5>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Nouveau mot de passe</label>
            <input type="password" name="password" class="form-control" style="font-size: 14px;">
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold" style="font-size: 13px;">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" style="font-size: 14px;">
        </div>

        <button type="submit" class="btn-possible w-100"><i class="fas fa-save me-2"></i> Mettre à jour l'utilisateur</button>
    </form>
</div>

@endsection
