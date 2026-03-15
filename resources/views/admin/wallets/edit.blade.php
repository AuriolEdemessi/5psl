@extends('layouts.dashboard')
@section('title', 'Modifier un Portefeuille')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.wallets.index') }}" class="text-decoration-none" style="color: var(--color-muted); font-size: 13px; font-weight: 600;">
        <i class="fas fa-arrow-left me-1"></i> Retour aux portefeuilles
    </a>
</div>

<div class="card-5psl" style="max-width: 600px;">
    <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 24px;"><i class="fas fa-wallet text-blue me-2"></i>Modifier le portefeuille</h4>

    <form action="{{ route('admin.wallets.update', $wallet->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px;">Nom du portefeuille <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $wallet->name) }}" required style="font-size: 14px;">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold" style="font-size: 13px;">Réseau</label>
                <input type="text" name="network" class="form-control" value="{{ old('network', $wallet->network) }}" style="font-size: 14px;">
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold" style="font-size: 13px;">Adresse Publique</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $wallet->address) }}" style="font-size: 14px;">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px; color: #ef4444;"><i class="fas fa-exclamation-triangle me-1"></i> Phrase de récupération (Seed Phrase)</label>
            <textarea name="recovery_phrase" class="form-control" rows="3" style="font-size: 14px; font-family: monospace;">{{ old('recovery_phrase', $wallet->recovery_phrase) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="font-size: 13px; color: #ef4444;"><i class="fas fa-key me-1"></i> Clé Privée</label>
            <input type="text" name="private_key" class="form-control" value="{{ old('private_key', $wallet->private_key) }}" style="font-size: 14px; font-family: monospace;">
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold" style="font-size: 13px;">Notes supplémentaires</label>
            <textarea name="notes" class="form-control" rows="2" style="font-size: 14px;">{{ old('notes', $wallet->notes) }}</textarea>
        </div>

        <button type="submit" class="btn-possible w-100"><i class="fas fa-save me-2"></i> Mettre à jour le portefeuille</button>
    </form>
</div>

@endsection
