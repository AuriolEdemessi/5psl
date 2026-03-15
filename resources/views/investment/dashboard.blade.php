@extends('layouts.dashboard')
@section('title', 'Portfolio')

@section('content')

@php
    $user = auth()->user();
    $totalParts = isset($investments) && $investments->count() > 0 ? $investments->sum('nombre_de_parts') : 0;
    $tier = $user->tier ?? 'STARTER';
    $hwm = (float) ($user->high_water_mark ?? 0);
    $plusValue = max(0, (float)$portfolioValue - $totalInvested);
@endphp

{{-- KYC Alerts --}}
@if($user->kyc_status === 'pending')
    <div class="alert-5psl alert-5psl-warning animate-fade-in">
        <i class="fas fa-clock"></i> Votre compte est en cours de vérification KYC. Certaines fonctionnalités peuvent être limitées.
    </div>
@elseif($user->kyc_status === 'rejected')
    <div class="alert-5psl alert-5psl-danger animate-fade-in">
        <i class="fas fa-exclamation-triangle"></i> Votre vérification KYC a été rejetée. Veuillez contacter le support.
    </div>
@endif

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
            <h2 class="section-title-sm" style="margin: 0;">Aperçu du Portefeuille</h2>
            <span class="tier-badge tier-{{ strtolower($tier) }}"><i class="fas fa-crown" style="font-size: 9px;"></i> {{ $tier }}</span>
        </div>
        <p class="section-subtitle">Bienvenue, {{ $user->name }}. NAV : <strong>{{ number_format((float)$nav, 4, ',', ' ') }} $</strong></p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('investment.transaction.form') }}" class="btn-possible btn-possible-outline btn-possible-sm">
            <i class="fas fa-arrow-right-arrow-left"></i> Dépôt / Retrait
        </a>
        <a href="{{ route('opportunities.index') }}" class="btn-possible btn-possible-primary btn-possible-sm">
            <i class="fas fa-lightbulb"></i> Opportunités
        </a>
    </div>
</div>

{{-- Main KPI Cards --}}
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-1">
        <div class="card-5psl kpi-card">
            <div class="kpi-icon" style="background: rgba(0,102,255,0.08); color: var(--possible-blue);">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="kpi-label">Valeur du Portefeuille</div>
            <div class="kpi-value animate-count">{{ number_format((float)$portfolioValue, 2, ',', ' ') }} <span style="font-size: 12px; font-weight: 600; color: var(--color-muted);">$</span></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-2">
        <div class="card-5psl kpi-card">
            <div class="kpi-icon" style="background: rgba(0,0,0,0.04); color: var(--possible-dark);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="kpi-label">Solde Disponible</div>
            <div class="kpi-value animate-count">{{ number_format((float)$balance, 2, ',', ' ') }} <span style="font-size: 12px; font-weight: 600; color: var(--color-muted);">$</span></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-3">
        <div class="card-5psl kpi-card">
            <div class="kpi-icon" style="background: {{ $roi >= 0 ? '#ecfdf5' : '#fef2f2' }}; color: {{ $roi >= 0 ? '#059669' : '#dc2626' }};">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="kpi-label">ROI</div>
            <div class="kpi-value animate-count" style="color: {{ $roi >= 0 ? '#059669' : '#dc2626' }};">
                {{ $roi >= 0 ? '+' : '' }}{{ number_format((float)$roi, 2, ',', ' ') }}%
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-4">
        <div class="card-5psl kpi-card">
            <div class="kpi-icon" style="background: #fffbeb; color: #d97706;">
                <i class="fas fa-coins"></i>
            </div>
            <div class="kpi-label">Parts Détenues</div>
            <div class="kpi-value animate-count">{{ number_format((float)$totalParts, 4, ',', ' ') }}</div>
        </div>
    </div>
</div>

{{-- Tier / HWM / Withdrawal Info Bar --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-fade-in-up delay-3">
        <div class="card-5psl card-5psl-flat" style="padding: 16px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="info-item-label">Capital Investi</div>
                    <div class="info-item-value text-mono">{{ number_format($totalInvested, 2, ',', ' ') }} $</div>
                </div>
                <div>
                    <div class="info-item-label">Plus-value</div>
                    <div class="info-item-value text-mono" style="color: {{ $plusValue >= 0 ? '#059669' : '#dc2626' }};">
                        {{ $plusValue >= 0 ? '+' : '' }}{{ number_format($plusValue, 2, ',', ' ') }} $
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-4">
        <div class="card-5psl card-5psl-flat" style="padding: 16px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="info-item-label">High-Water Mark</div>
                    <div class="info-item-value text-mono">{{ number_format($hwm, 2, ',', ' ') }} $</div>
                </div>
                <div title="Sommet historique de votre portefeuille">
                    <i class="fas fa-mountain" style="color: var(--color-muted); font-size: 20px;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-5">
        <div class="card-5psl card-5psl-flat" style="padding: 16px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="info-item-label">Gains retirables</div>
                    <div class="info-item-value text-mono" style="color: {{ $withdrawable['can_withdraw'] ? '#059669' : '#d97706' }};">
                        {{ number_format($withdrawable['montant_retirable'], 2, ',', ' ') }} $
                    </div>
                </div>
                @if(!$withdrawable['can_withdraw'])
                    <span class="badge-5psl badge-warning"><i class="fas fa-clock me-1"></i>{{ $withdrawable['days_remaining'] }}j</span>
                @else
                    <span class="badge-5psl badge-success"><i class="fas fa-check me-1"></i>Ouvert</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Voting Banner --}}
@if(isset($activeOpportunities) && $activeOpportunities->count() > 0)
<div class="card-5psl card-gradient-blue mb-4 animate-scale-in delay-4" style="padding: 24px 28px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <i class="fas fa-bullhorn" style="font-size: 18px; opacity: 0.8;"></i>
                <span style="font-size: 17px; font-weight: 800;">{{ $activeOpportunities->count() }} opportunité(s) en attente de vote</span>
            </div>
            <p style="margin: 0; opacity: 0.75; font-size: 13px;">Votre voix compte pour le prochain investissement du club.</p>
        </div>
        <a href="{{ route('opportunities.index') }}" class="btn-possible" style="background: white; color: var(--possible-blue); white-space: nowrap;">
            Voir et Voter <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>
@endif

<div class="row g-3">
    {{-- Left Column: Investments + Allocation --}}
    <div class="col-lg-8">
        {{-- Investments Table --}}
        <div class="card-5psl animate-fade-in-up delay-5" style="padding: 0; overflow: hidden; margin-bottom: 16px;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-size: 16px; font-weight: 800; margin: 0;">Vos Actifs</h4>
                <span class="badge-5psl badge-dark">{{ ($investments ?? collect())->count() }} position(s)</span>
            </div>
            <div class="table-responsive">
                <table class="table-5psl">
                    <thead>
                        <tr>
                            <th>Actif</th>
                            <th>Catégorie</th>
                            <th>Parts</th>
                            <th>Investi</th>
                            <th>Valeur / P&L</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($investments ?? [] as $investment)
                            @php
                                $assetNav = $investment->asset ? (float)$investment->asset->valeur_actuelle : 0;
                                $valeurActuelle = (float)$investment->nombre_de_parts * $assetNav;
                                $gain = $valeurActuelle - (float)$investment->montant;
                                $gainPct = (float)$investment->montant > 0 ? ($gain / (float)$investment->montant) * 100 : 0;
                                $cat = $investment->asset->categorie ?? 'securite';
                                $catColors = ['securite' => '#0066ff', 'croissance' => '#059669', 'opportunite' => '#d97706'];
                            @endphp
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--possible-dark);">{{ $investment->asset->nom ?? 'N/A' }}</div>
                                    <div style="font-size: 11px; color: var(--color-muted);">{{ ucfirst($investment->asset->type ?? '') }}</div>
                                </td>
                                <td>
                                    <span style="font-size: 11px; font-weight: 700; color: {{ $catColors[$cat] ?? '#666' }}; background: {{ $catColors[$cat] ?? '#666' }}15; padding: 3px 8px; border-radius: 4px;">
                                        {{ ucfirst($cat) }}
                                    </span>
                                </td>
                                <td class="text-mono">{{ number_format((float)$investment->nombre_de_parts, 4, ',', ' ') }}</td>
                                <td class="text-mono">{{ number_format((float)$investment->montant, 2, ',', ' ') }} $</td>
                                <td>
                                    <div class="text-mono" style="font-weight: 700;">{{ number_format($valeurActuelle, 2, ',', ' ') }} $</div>
                                    <div style="font-size: 11px; color: {{ $gain >= 0 ? '#059669' : '#dc2626' }}; font-weight: 700;">
                                        {{ $gain >= 0 ? '+' : '' }}{{ number_format($gain, 2, ',', ' ') }} $ ({{ $gain >= 0 ? '+' : '' }}{{ number_format($gainPct, 1) }}%)
                                    </div>
                                </td>
                                <td style="color: var(--color-muted); font-size: 13px;">{{ $investment->date->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-state-icon"><i class="fas fa-chart-pie"></i></div>
                                        <h4>Aucun investissement</h4>
                                        <p>Commencez à investir pour construire votre portefeuille.</p>
                                        <a href="{{ route('investment.transaction.form') }}" class="btn-possible btn-possible-primary btn-possible-sm mt-3">
                                            <i class="fas fa-plus"></i> Faire un dépôt
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Portfolio Allocation --}}
        @if(!empty($allocation))
        <div class="card-5psl animate-fade-in-up delay-6" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 16px; font-weight: 800; margin: 0;"><i class="fas fa-pie-chart me-2" style="color: var(--possible-blue);"></i>Répartition du portefeuille (50/30/20)</h4>
            </div>
            <div style="padding: 20px 24px;">
                @php
                    $catLabels = ['securite' => ['Sécurité', 'fa-shield-alt', '#0066ff'], 'croissance' => ['Croissance', 'fa-chart-line', '#059669'], 'opportunite' => ['Opportunités', 'fa-rocket', '#d97706']];
                @endphp
                @foreach($allocation as $cat => $data)
                    @php $meta = $catLabels[$cat] ?? ['Autre', 'fa-circle', '#666']; @endphp
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span style="font-size: 13px; font-weight: 700;">
                                <i class="fas {{ $meta[1] }} me-1" style="color: {{ $meta[2] }};"></i> {{ $meta[0] }}
                            </span>
                            <span style="font-size: 12px;">
                                <strong style="color: {{ $meta[2] }};">{{ number_format($data['actuel'] * 100, 1) }}%</strong>
                                <span style="color: var(--color-muted);"> / {{ number_format($data['cible'] * 100, 0) }}%</span>
                            </span>
                        </div>
                        <div class="progress-5psl">
                            <div class="progress-5psl-bar" style="width: {{ min($data['actuel'] * 100, 100) }}%; background: {{ $meta[2] }};"></div>
                        </div>
                        <div style="font-size: 11px; color: var(--color-muted); margin-top: 4px;">
                            {{ number_format($data['valeur'], 2, ',', ' ') }} $
                            @if($data['ecart'] > 0.01)
                                <span style="color: var(--color-warning);"> (+{{ number_format($data['ecart'] * 100, 1) }}% au-dessus)</span>
                            @elseif($data['ecart'] < -0.01)
                                <span style="color: var(--possible-blue);"> ({{ number_format($data['ecart'] * 100, 1) }}% en-dessous)</span>
                            @else
                                <span style="color: var(--color-success);"> (Équilibré)</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Right Column: Transactions + Info --}}
    <div class="col-lg-4">
        {{-- Recent Transactions --}}
        <div class="card-5psl animate-slide-right delay-5" style="padding: 0; overflow: hidden; margin-bottom: 16px;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-size: 16px; font-weight: 800; margin: 0;">Transactions</h4>
                <span class="badge-5psl badge-info">{{ ($recentTransactions ?? collect())->count() }}</span>
            </div>

            @forelse($recentTransactions ?? [] as $transaction)
                <div style="padding: 14px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px;
                            background: {{ $transaction->type === 'depot' ? '#ecfdf5' : '#fef2f2' }};
                            color: {{ $transaction->type === 'depot' ? '#059669' : '#dc2626' }};">
                            <i class="fas {{ $transaction->type === 'depot' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 13px;">{{ $transaction->type === 'depot' ? 'Dépôt' : 'Retrait' }}</div>
                            <div style="font-size: 10px; color: var(--color-muted);">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="text-mono" style="font-weight: 800; font-size: 13px; color: {{ $transaction->type === 'depot' ? '#059669' : '#121212' }};">
                            {{ $transaction->type === 'depot' ? '+' : '-' }}{{ number_format((float)$transaction->montant, 2, ',', ' ') }} $
                        </div>
                        @if((float)$transaction->frais_entree > 0)
                            <div style="font-size: 10px; color: var(--color-muted);">Frais: {{ number_format((float)$transaction->frais_entree, 2) }} $</div>
                        @endif
                        <div style="margin-top: 2px;">
                            @if(in_array($transaction->statut, ['valide', 'approuve']))
                                <span class="badge-5psl badge-success" style="font-size: 9px;">Validé</span>
                            @elseif($transaction->statut === 'en_attente')
                                <span class="badge-5psl badge-warning" style="font-size: 9px;">En attente</span>
                            @else
                                <span class="badge-5psl badge-danger" style="font-size: 9px;">Rejeté</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="padding: 36px 20px;">
                    <div class="empty-state-icon"><i class="fas fa-receipt"></i></div>
                    <h4>Aucune transaction</h4>
                    <p>Vos dépôts et retraits apparaîtront ici.</p>
                </div>
            @endforelse

            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <div style="padding: 14px; text-align: center; border-top: 1px solid var(--color-border);">
                    <a href="{{ route('investment.transaction.form') }}" style="color: var(--possible-blue); font-size: 13px; font-weight: 700;">
                        Nouvelle transaction <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endif
        </div>

        {{-- Account Summary Card --}}
        <div class="card-5psl animate-slide-right delay-6" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-user-shield me-2" style="color: var(--possible-blue);"></i>Mon Compte</h4>
            </div>
            <div style="padding: 16px 24px;">
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Palier</span>
                    <span class="tier-badge tier-{{ strtolower($tier) }}">{{ $tier }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Adhésion annuelle</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ number_format($user->getAnnualFee(), 0) }} $/an</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Frais d'entrée</span>
                    <span style="font-size: 13px; font-weight: 700;">2%</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Commission HWM</span>
                    <span style="font-size: 13px; font-weight: 700;">30% des gains</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0;">
                    <span style="font-size: 12px; color: var(--color-muted);">KYC</span>
                    @if($user->kyc_status === 'verified')
                        <span class="badge-5psl badge-success"><i class="fas fa-check me-1"></i>Vérifié</span>
                    @elseif($user->kyc_status === 'pending')
                        <span class="badge-5psl badge-warning"><i class="fas fa-clock me-1"></i>En cours</span>
                    @else
                        <span class="badge-5psl badge-danger"><i class="fas fa-times me-1"></i>Rejeté</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
