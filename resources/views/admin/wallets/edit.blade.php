@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a href="{{ route('admin.wallets.index') }}">Portefeuilles</a></li>
            <li class="breadcrumb-item active">Modifier</li>
          </ol>
        </nav>
        <h1 class="page-header-title">Modifier : {{ $wallet->name }}</h1>
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
        <div class="card-header"><h4 class="card-header-title"><i class="bi-wallet2 me-2"></i>Informations du portefeuille</h4></div>
        <div class="card-body">
          <form action="{{ route('admin.wallets.update', $wallet->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Nom du portefeuille <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $wallet->name) }}" required>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Réseau</label>
                <input type="text" name="network" class="form-control" value="{{ old('network', $wallet->network) }}">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Adresse Publique</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $wallet->address) }}">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label text-danger"><i class="bi-exclamation-triangle me-1"></i>Phrase de récupération</label>
              <textarea name="recovery_phrase" class="form-control" rows="3" style="font-family: monospace;">{{ old('recovery_phrase', $wallet->recovery_phrase) }}</textarea>
            </div>
            <div class="mb-3">
              <label class="form-label text-danger"><i class="bi-key me-1"></i>Clé Privée</label>
              <input type="text" name="private_key" class="form-control" value="{{ old('private_key', $wallet->private_key) }}" style="font-family: monospace;">
            </div>
            <div class="mb-4">
              <label class="form-label">Notes</label>
              <textarea name="notes" class="form-control" rows="2">{{ old('notes', $wallet->notes) }}</textarea>
            </div>
            <div class="d-flex justify-content-end gap-3">
              <a href="{{ route('admin.wallets.index') }}" class="btn btn-white">Annuler</a>
              <button type="submit" class="btn btn-primary"><i class="bi-check-lg me-1"></i> Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
