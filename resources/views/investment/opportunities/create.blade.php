@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter">
          <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('opportunities.index') }}">Opportunités</a></li>
          <li class="breadcrumb-item active" aria-current="page">Publier</li>
        </ol>
      </nav>
      <h1 class="page-header-title">Publier une Opportunité</h1>
      <p class="page-header-text">Soumettez un nouveau projet au vote des membres du club.</p>
    </div>
  </div>
</div>
<!-- End Page Header -->

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            @if($errors->any())
                <div class="alert alert-soft-danger m-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('opportunities.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label" for="titre">Titre du projet <span class="text-danger">*</span></label>
                        <input type="text" name="titre" id="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required placeholder="Ex: Acquisition d'un terrain à Bingerville">
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label class="form-label" for="type">Type d'investissement <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="">Sélectionnez un type...</option>
                                <option value="immobilier" {{ old('type') == 'immobilier' ? 'selected' : '' }}>Immobilier</option>
                                <option value="action" {{ old('type') == 'action' ? 'selected' : '' }}>Actions / Bourse</option>
                                <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>Cryptomonnaie</option>
                                <option value="obligation" {{ old('type') == 'obligation' ? 'selected' : '' }}>Obligations</option>
                                <option value="fonds" {{ old('type') == 'fonds' ? 'selected' : '' }}>Fonds d'investissement</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="montant_estime">Montant estimé requis (FCFA)</label>
                            <input type="number" name="montant_estime" id="montant_estime" class="form-control" value="{{ old('montant_estime') }}" step="0.01" min="0" placeholder="Ex: 15000000">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="date_limite_vote">Date limite pour le vote</label>
                        <input type="date" name="date_limite_vote" id="date_limite_vote" class="form-control" value="{{ old('date_limite_vote') }}" min="{{ date('Y-m-d') }}">
                        <span class="form-text">Si non renseignée, le vote restera ouvert indéfiniment jusqu'à sa clôture manuelle.</span>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label" for="description">Description détaillée & Analyse <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="8" required placeholder="Décrivez le projet en détail: localisation, risques, retour sur investissement attendu, durée, etc.">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="alert alert-soft-success mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi-bell fs-2 me-3"></i>
                            <p class="mb-0 fw-semibold">Une notification email sera automatiquement envoyée à tous les membres du club dès la publication de cette opportunité.</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('opportunities.index') }}" class="btn btn-white me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Publier l'opportunité</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
