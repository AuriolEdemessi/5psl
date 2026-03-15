@extends('layouts.dashboard')
@section('title', 'Nouvelle Opportunité')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Publier une Opportunité</h2>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Soumettez un nouveau projet au vote des membres du club.</p>
    </div>
    <a href="{{ route('opportunities.index') }}" class="btn-possible btn-possible-outline">
        <i class="fas fa-arrow-left me-2"></i>Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-12 max-w-3xl">
        <div class="card-5psl">
            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    <ul style="margin: 0; padding-left: 20px; font-size: 14px; font-weight: 500;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('opportunities.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Titre du projet <span style="color: #dc2626;">*</span></label>
                    <input type="text" name="titre" class="input-5psl @error('titre') is-invalid @enderror" value="{{ old('titre') }}" required placeholder="Ex: Acquisition d'un terrain à Bingerville">
                </div>
                
                <div class="row g-4 mb-24">
                    <div class="col-md-6" style="margin-bottom: 24px;">
                        <label class="form-label-custom">Type d'investissement <span style="color: #dc2626;">*</span></label>
                        <select name="type" class="input-5psl" required style="cursor: pointer; appearance: auto;">
                            <option value="">Sélectionnez un type...</option>
                            <option value="immobilier" {{ old('type') == 'immobilier' ? 'selected' : '' }}>Immobilier</option>
                            <option value="action" {{ old('type') == 'action' ? 'selected' : '' }}>Actions / Bourse</option>
                            <option value="crypto" {{ old('type') == 'crypto' ? 'selected' : '' }}>Cryptomonnaie</option>
                            <option value="obligation" {{ old('type') == 'obligation' ? 'selected' : '' }}>Obligations</option>
                            <option value="fonds" {{ old('type') == 'fonds' ? 'selected' : '' }}>Fonds d'investissement</option>
                            <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6" style="margin-bottom: 24px;">
                        <label class="form-label-custom">Montant estimé requis (FCFA)</label>
                        <input type="number" name="montant_estime" class="input-5psl" value="{{ old('montant_estime') }}" step="0.01" min="0" placeholder="Ex: 15000000">
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Date limite pour le vote</label>
                    <input type="date" name="date_limite_vote" class="input-5psl" value="{{ old('date_limite_vote') }}" min="{{ date('Y-m-d') }}">
                    <div style="font-size: 12px; color: #666; margin-top: 6px;">Si non renseignée, le vote restera ouvert indéfiniment jusqu'à sa clôture manuelle.</div>
                </div>
                
                <div style="margin-bottom: 32px;">
                    <label class="form-label-custom">Description détaillée & Analyse <span style="color: #dc2626;">*</span></label>
                    <textarea name="description" class="input-5psl" rows="8" required placeholder="Décrivez le projet en détail: localisation, risques, retour sur investissement attendu, durée, etc.">{{ old('description') }}</textarea>
                </div>
                
                <div style="background: rgba(0, 255, 0, 0.05); border: 1px solid rgba(0, 255, 0, 0.1); border-radius: 8px; padding: 16px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 12px;">
                    <i class="fas fa-bell" style="color: #059669; font-size: 20px; margin-top: 2px;"></i>
                    <p style="font-size: 13px; color: #059669; font-weight: 600; margin: 0;">Une notification email sera automatiquement envoyée à tous les membres du club dès la publication de cette opportunité.</p>
                </div>

                <div style="display: flex; justify-content: flex-end; border-top: 1px solid #eee; padding-top: 24px;">
                    <button type="submit" class="btn-possible btn-possible-success">Publier l'opportunité</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
