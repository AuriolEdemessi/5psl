@extends('layouts.dashboard')
@section('title', 'Nouveau Ticket')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Nouveau Ticket d'Assistance</h2>
        <p class="section-subtitle">Décrivez votre problème et un administrateur vous répondra dans les plus brefs délais.</p>
    </div>
    <a href="{{ route('support.index') }}" class="btn-possible btn-possible-outline btn-possible-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="row g-3">
    <div class="col-lg-8 animate-fade-in-up delay-1">
        <div class="card-5psl">
            <form action="{{ route('support.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Sujet</label>
                    <input type="text" name="subject" class="input-5psl" required placeholder="Ex: Problème de dépôt USDT" value="{{ old('subject') }}">
                    @error('subject')
                        <div style="color: var(--color-danger); font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3" style="margin-bottom: 20px;">
                    <div class="col-md-6">
                        <label class="form-label-custom">Catégorie</label>
                        <select name="category" class="input-5psl" required>
                            <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>Général</option>
                            <option value="depot" {{ old('category') === 'depot' ? 'selected' : '' }}>Dépôt</option>
                            <option value="retrait" {{ old('category') === 'retrait' ? 'selected' : '' }}>Retrait</option>
                            <option value="investissement" {{ old('category') === 'investissement' ? 'selected' : '' }}>Investissement</option>
                            <option value="kyc" {{ old('category') === 'kyc' ? 'selected' : '' }}>KYC / Vérification</option>
                            <option value="technique" {{ old('category') === 'technique' ? 'selected' : '' }}>Technique</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Priorité</label>
                        <select name="priority" class="input-5psl" required>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Votre message</label>
                    <textarea name="body" class="input-5psl" rows="6" required placeholder="Décrivez votre problème en détail...">{{ old('body') }}</textarea>
                    @error('body')
                        <div style="color: var(--color-danger); font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; justify-content: flex-end; border-top: 1px solid var(--color-border); padding-top: 20px;">
                    <button type="submit" class="btn-possible btn-possible-primary">
                        <i class="fas fa-paper-plane me-1"></i> Envoyer le ticket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4 animate-slide-right delay-2">
        <div class="card-5psl" style="background: #f8fafc; border: 1px dashed var(--color-border);">
            <h4 style="font-size: 14px; font-weight: 800; margin-bottom: 14px;"><i class="fas fa-lightbulb me-2" style="color: var(--color-warning);"></i>Conseils</h4>
            <ul style="font-size: 12px; color: var(--color-text); line-height: 1.8; padding-left: 16px; margin: 0;">
                <li><strong>Dépôt non crédité :</strong> Indiquez le hash de transaction, le réseau et le montant.</li>
                <li><strong>Retrait en attente :</strong> Précisez l'adresse de destination et le montant demandé.</li>
                <li><strong>KYC :</strong> Si votre vérification est rejetée, joignez les documents demandés.</li>
                <li><strong>Investissement :</strong> Pour toute question sur la NAV, vos parts, ou les frais.</li>
            </ul>
        </div>

        <div class="card-5psl mt-3" style="padding: 18px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 12px; font-weight: 800; color: var(--possible-dark);">Temps de réponse</div>
                    <div style="font-size: 11px; color: var(--color-muted);">Généralement sous 24h ouvrées</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
