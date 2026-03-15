@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
            <li class="breadcrumb-item active">Éditer</li>
          </ol>
        </nav>
        <h1 class="page-header-title">Éditer : {{ $user->name }}</h1>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-3 mb-lg-5">
        <div class="card-header"><h4 class="card-header-title"><i class="bi-person me-2"></i>Informations du compte</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Nom complet</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Adresse Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Rôle</label>
                <select name="role" class="form-select" required>
                  <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Membre</option>
                  <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                  @if(Auth::user()->role === 'superadmin' || $user->role === 'superadmin')
                    <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                  @endif
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Tier</label>
                <select name="tier" class="form-select">
                  <option value="STARTER" {{ old('tier', $user->tier) == 'STARTER' ? 'selected' : '' }}>STARTER</option>
                  <option value="PRO" {{ old('tier', $user->tier) == 'PRO' ? 'selected' : '' }}>PRO</option>
                  <option value="ELITE" {{ old('tier', $user->tier) == 'ELITE' ? 'selected' : '' }}>ELITE</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Statut KYC</label>
                <select name="kyc_status" class="form-select" required>
                  <option value="not_started" {{ old('kyc_status', $user->kyc_status) == 'not_started' ? 'selected' : '' }}>Non soumis</option>
                  <option value="pending" {{ old('kyc_status', $user->kyc_status) == 'pending' ? 'selected' : '' }}>En attente</option>
                  <option value="verified" {{ old('kyc_status', $user->kyc_status) == 'verified' ? 'selected' : '' }}>Vérifié</option>
                  <option value="rejected" {{ old('kyc_status', $user->kyc_status) == 'rejected' ? 'selected' : '' }}>Rejeté</option>
                </select>
              </div>
            </div>

            <hr class="my-4">
            <h4 class="mb-3">Modifier le mot de passe <span class="badge bg-soft-secondary text-secondary">Optionnel</span></h4>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Confirmer</label>
                <input type="password" name="password_confirmation" class="form-control">
              </div>
            </div>

            <div class="d-flex justify-content-end gap-3">
              <a href="{{ route('admin.users.index') }}" class="btn btn-white">Annuler</a>
              <button type="submit" class="btn btn-primary"><i class="bi-check-lg me-1"></i> Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
