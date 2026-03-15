@extends('layouts.dashboard')
@section('title', 'Portefeuilles du Club')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Portefeuilles du Club</h2>
        <p class="section-subtitle">Gérez les portefeuilles qui détiennent les fonds globaux du club (trésorerie centrale).</p>
    </div>
    <div>
        <a href="{{ route('admin.wallets.create') }}" class="btn-possible" style="font-size: 13px;">
            <i class="fas fa-plus me-1"></i> Ajouter un portefeuille
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($wallets as $wallet)
        <div class="col-md-6 col-lg-4">
            <div class="card-5psl position-relative" style="background: #1e293b; color: white;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 style="font-size: 16px; font-weight: 800; margin: 0; color: var(--possible-blue);">{{ $wallet->name }}</h4>
                        <span style="font-size: 11px; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 12px;">{{ $wallet->network ?? 'Réseau non spécifié' }}</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm text-white" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('admin.wallets.edit', $wallet->id) }}"><i class="fas fa-edit me-2"></i> Modifier</a></li>
                            <li>
                                <form action="{{ route('admin.wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce portefeuille ?');">
                                    @csrf @method('DELETE')
                                    <button class="dropdown-item text-danger"><i class="fas fa-trash-alt me-2"></i> Supprimer</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mb-3">
                    <div style="font-size: 11px; opacity: 0.6; text-transform: uppercase;">Adresse Publique</div>
                    <div style="font-family: monospace; font-size: 12px; background: rgba(0,0,0,0.3); padding: 8px; border-radius: 6px; word-break: break-all;">
                        {{ $wallet->address ?? 'Non définie' }}
                    </div>
                </div>

                @if($wallet->recovery_phrase)
                    <div class="mb-3">
                        <div style="font-size: 11px; color: #ef4444; text-transform: uppercase; font-weight: 800;"><i class="fas fa-exclamation-triangle me-1"></i> Phrase de récupération (Secrète)</div>
                        <div class="recovery-phrase-container" style="filter: blur(5px); transition: filter 0.3s; cursor: pointer; font-family: monospace; font-size: 12px; background: rgba(239, 68, 68, 0.1); border: 1px dashed #ef4444; padding: 8px; border-radius: 6px; word-break: break-word;" onmouseover="this.style.filter='blur(0)'" onmouseout="this.style.filter='blur(5px)'">
                            {{ $wallet->recovery_phrase }}
                        </div>
                    </div>
                @endif

                @if($wallet->private_key)
                    <div class="mb-3">
                        <div style="font-size: 11px; color: #ef4444; text-transform: uppercase; font-weight: 800;"><i class="fas fa-key me-1"></i> Clé Privée (Secrète)</div>
                        <div class="private-key-container" style="filter: blur(5px); transition: filter 0.3s; cursor: pointer; font-family: monospace; font-size: 12px; background: rgba(239, 68, 68, 0.1); border: 1px dashed #ef4444; padding: 8px; border-radius: 6px; word-break: break-all;" onmouseover="this.style.filter='blur(0)'" onmouseout="this.style.filter='blur(5px)'">
                            {{ $wallet->private_key }}
                        </div>
                    </div>
                @endif

                @if($wallet->notes)
                    <div style="font-size: 12px; opacity: 0.8; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px; margin-top: 12px;">
                        <i class="fas fa-sticky-note me-1"></i> {{ $wallet->notes }}
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-wallet"></i></div>
                <h4>Aucun portefeuille configuré</h4>
                <p>Ajoutez les portefeuilles centraux du club pour sécuriser les phrases de récupération (12 mots).</p>
                <a href="{{ route('admin.wallets.create') }}" class="btn-possible mt-3">Ajouter un portefeuille</a>
            </div>
        </div>
    @endforelse
</div>

@endsection
