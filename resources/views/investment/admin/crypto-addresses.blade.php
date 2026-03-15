@extends('layouts.dashboard')
@section('title', 'Adresses Crypto')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Gestion des Adresses Crypto</h2>
        <p class="section-subtitle">Ajoutez et gérez les adresses USDT/USDC de réception du club sur chaque réseau.</p>
    </div>
</div>

{{-- Add new address form --}}
<div class="card-5psl mb-4 animate-fade-in-up delay-1">
    <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 20px;"><i class="fas fa-plus-circle me-2" style="color: var(--possible-blue);"></i>Ajouter une adresse</h4>
    <form action="{{ route('admin.crypto.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label-custom">Coin</label>
                <select name="coin" class="input-5psl" required>
                    <option value="USDT">USDT</option>
                    <option value="USDC">USDC</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-custom">Réseau</label>
                <select name="network" class="input-5psl" required>
                    <option value="TRC20 (Tron)">TRC20 (Tron)</option>
                    <option value="ERC20 (Ethereum)">ERC20 (Ethereum)</option>
                    <option value="BEP20 (BSC)">BEP20 (BSC)</option>
                    <option value="SOL (Solana)">SOL (Solana)</option>
                    <option value="Polygon">Polygon</option>
                    <option value="Arbitrum">Arbitrum</option>
                    <option value="Optimism">Optimism</option>
                    <option value="Avalanche C-Chain">Avalanche C-Chain</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label-custom">Adresse</label>
                <input type="text" name="address" class="input-5psl" required placeholder="0x... ou T...">
            </div>
            <div class="col-md-2">
                <label class="form-label-custom">Libellé (opt.)</label>
                <input type="text" name="label" class="input-5psl" placeholder="Ex: Principal">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn-possible btn-possible-primary btn-possible-sm w-100">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Addresses list --}}
@forelse($grouped as $coin => $coinAddresses)
    <div class="card-5psl mb-3 animate-fade-in-up delay-{{ $loop->iteration + 1 }}" style="padding: 0; overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $coin === 'USDT' ? '#ecfdf5' : '#eff6ff' }}; color: {{ $coin === 'USDT' ? '#059669' : '#2563eb' }}; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 11px;">
                    {{ $coin }}
                </div>
                <h4 style="font-size: 16px; font-weight: 800; margin: 0;">{{ $coin }}</h4>
                <span class="badge-5psl badge-dark">{{ count($coinAddresses) }} adresse(s)</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table-5psl">
                <thead>
                    <tr>
                        <th>Réseau</th>
                        <th>Adresse</th>
                        <th>Libellé</th>
                        <th>Statut</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coinAddresses as $addr)
                        <tr style="{{ !$addr['is_active'] ? 'opacity: 0.5;' : '' }}">
                            <td>
                                <span style="font-weight: 700; font-size: 13px;">{{ $addr['network'] }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <code style="font-size: 12px; background: #f1f5f9; padding: 4px 8px; border-radius: 4px; word-break: break-all; max-width: 350px;">{{ $addr['address'] }}</code>
                                    <button type="button" class="btn-possible btn-possible-xs" style="background: #f1f5f9; border: none; font-size: 11px;" onclick="copyToClipboard('{{ $addr['address'] }}', this)">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td style="color: var(--color-muted); font-size: 13px;">{{ $addr['label'] ?? '—' }}</td>
                            <td>
                                @if($addr['is_active'])
                                    <span class="badge-5psl badge-success"><i class="fas fa-check me-1"></i>Active</span>
                                @else
                                    <span class="badge-5psl badge-danger"><i class="fas fa-times me-1"></i>Inactive</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <form action="{{ route('admin.crypto.toggle', $addr['id']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-possible btn-possible-xs" style="background: {{ $addr['is_active'] ? '#fffbeb' : '#ecfdf5' }}; color: {{ $addr['is_active'] ? '#d97706' : '#059669' }}; border: 1px solid {{ $addr['is_active'] ? '#fde68a' : '#a7f3d0' }};">
                                            <i class="fas {{ $addr['is_active'] ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.crypto.destroy', $addr['id']) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette adresse ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-possible btn-possible-xs" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="card-5psl animate-fade-in-up delay-2">
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-wallet"></i></div>
            <h4>Aucune adresse crypto configurée</h4>
            <p>Ajoutez vos premières adresses USDT/USDC ci-dessus pour que les membres puissent déposer.</p>
        </div>
    </div>
@endforelse

{{-- Info card --}}
<div class="card-5psl mt-3 animate-fade-in-up" style="background: #f8fafc; border: 1px dashed var(--color-border);">
    <div style="display: flex; align-items: flex-start; gap: 12px;">
        <i class="fas fa-info-circle" style="color: var(--possible-blue); margin-top: 2px;"></i>
        <div style="font-size: 12px; color: var(--color-text); line-height: 1.7;">
            <strong>Fonctionnement :</strong> Les adresses actives sont automatiquement affichées aux membres dans le formulaire de dépôt.
            Lors d'un dépôt, le membre sélectionne le réseau et voit l'adresse correspondante. Le dépôt est soumis en attente de validation admin.
            <br><strong>Réseaux recommandés :</strong> TRC20 (frais faibles), BEP20 (rapide), ERC20 (plus cher mais standard).
        </div>
    </div>
</div>

@endsection
