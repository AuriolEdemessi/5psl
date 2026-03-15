@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
            <li class="breadcrumb-item active">Créer</li>
          </ol>
        </nav>
        <h1 class="page-header-title">Créer un nouvel utilisateur</h1>
      </div>
    </div>
  </div>

  @if($errors->any())
    <div class="alert alert-soft-danger mb-4">
      <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header"><h4 class="card-header-title"><i class="bi-person-plus me-2"></i>Informations du compte</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nom complet</label>
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Adresse Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Rôle</label>
              <select name="role" class="form-select" required>
                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Membre</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
              </select>
              <span class="form-text">Les administrateurs ont accès à la gestion du club, des membres et des transactions.</span>
            </div>
            <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-4">
              <label class="form-label">Confirmer le mot de passe</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end gap-3">
              <a href="{{ route('admin.users.index') }}" class="btn btn-white">Annuler</a>
              <button type="submit" class="btn btn-primary"><i class="bi-plus-circle me-1"></i> Créer le compte</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
