@extends('layouts.dashboard')
@section('title', 'Gestion du Club')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Administration du Club</h2>
        <p class="section-subtitle">Vue d'ensemble, gestion des membres, validation des transactions.</p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('opportunities.create') }}" class="btn-possible btn-possible-primary btn-possible-sm">
            <i class="fas fa-plus"></i> Nouvelle Opportunité
        </a>
    </div>
</div>

{{-- Global AUM Banner --}}
<div class="card-5psl card-gradient-dark mb-4 animate-fade-in-up delay-1" style="padding: 28px 32px;">
    <div class="row align-items-center">
        <div class="col-md-4" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Actifs sous gestion (AUM)</div>
            <div style="font-size: 32px; font-weight: 900; letter-spacing: -1px;" class="text-mono">{{ number_format($totalAUM, 2, ',', ' ') }} <span style="font-size: 14px; opacity: 0.6;">$</span></div>
        </div>
        <div class="col-md-2 text-center" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">NAV / Part</div>
            <div style="font-size: 22px; font-weight: 900;" class="text-mono">{{ number_format((float)$nav, 4, ',', ' ') }}</div>
        </div>
        <div class="col-md-2 text-center" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Parts totales</div>
            <div style="font-size: 22px; font-weight: 900;" class="text-mono">{{ number_format($totalShares, 2, ',', ' ') }}</div>
        </div>
        <div class="col-md-2 text-center" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Membres</div>
            <div style="font-size: 22px; font-weight: 900;">{{ $totalMembers }}</div>
        </div>
        <div class="col-md-2 text-center">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Opportunités</div>
            <div style="font-size: 22px; font-weight: 900;">{{ $activeOpportunitiesCount }}</div>
        </div>
    </div>
</div>

{{-- Action KPIs --}}
<div class="row g-3 mb-4">
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-1">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">KYC en attente</div>
                    <div class="kpi-value" style="color: {{ ($pendingKycCount ?? 0) > 0 ? '#d97706' : '#059669' }};">{{ $pendingKycCount ?? 0 }}</div>
                </div>
                <div class="kpi-icon" style="background: rgba(0,102,255,0.08); color: var(--possible-blue); margin-bottom: 0;">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-2">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Transactions en attente</div>
                    <div class="kpi-value" style="color: {{ ($pendingTransactionsCount ?? 0) > 0 ? '#d97706' : '#059669' }};">{{ $pendingTransactionsCount ?? 0 }}</div>
                </div>
                <div class="kpi-icon" style="background: #fffbeb; color: #d97706; margin-bottom: 0;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-3">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Total Frais perçus</div>
                    <div class="kpi-value text-mono">{{ number_format($totalFees, 2, ',', ' ') }} <span style="font-size: 12px; color: var(--color-muted);">$</span></div>
                </div>
                <div class="kpi-icon" style="background: #ecfdf5; color: #059669; margin-bottom: 0;">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 animate-fade-in-up delay-4">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Commissions HWM</div>
                    <div class="kpi-value text-mono">{{ number_format($totalCommissions, 2, ',', ' ') }} <span style="font-size: 12px; color: var(--color-muted);">$</span></div>
                </div>
                <div class="kpi-icon" style="background: #fdf4ff; color: #9333ea; margin-bottom: 0;">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Tier Breakdown + Allocation --}}
    <div class="col-lg-4 animate-fade-in-up delay-3">
        {{-- Tier Breakdown --}}
        <div class="card-5psl mb-3" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-layer-group me-2" style="color: var(--possible-blue);"></i>Répartition par palier</h4>
            </div>
            <div style="padding: 16px 24px;">
                @php
                    $tierColors = ['STARTER' => ['#0284c7', '#e0f2fe'], 'PRO' => ['#a16207', '#fef9c3'], 'ELITE' => ['#9333ea', '#f5d0fe']];
                    $tierTotal = max(array_sum($tierBreakdown), 1);
                @endphp
                @foreach($tierBreakdown as $tierName => $count)
                    @php $tc = $tierColors[$tierName] ?? ['#666', '#f1f5f9']; @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; {{ !$loop->last ? 'border-bottom: 1px solid #f1f5f9;' : '' }}">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="tier-badge tier-{{ strtolower($tierName) }}">{{ $tierName }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="progress-5psl" style="width: 60px;">
                                <div class="progress-5psl-bar" style="width: {{ ($count / $tierTotal) * 100 }}%; background: {{ $tc[0] }};"></div>
                            </div>
                            <span style="font-size: 14px; font-weight: 800; min-width: 24px; text-align: right;">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Portfolio Allocation --}}
        @if(!empty($allocation))
        <div class="card-5psl" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-pie-chart me-2" style="color: var(--possible-blue);"></i>Allocation (50/30/20)</h4>
            </div>
            <div style="padding: 16px 24px;">
                @php
                    $catMeta = ['securite' => ['Sécurité', 'fa-shield-alt', '#0066ff'], 'croissance' => ['Croissance', 'fa-chart-line', '#059669'], 'opportunite' => ['Opportunités', 'fa-rocket', '#d97706']];
                @endphp
                @foreach($allocation as $cat => $data)
                    @php $m = $catMeta[$cat] ?? ['Autre', 'fa-circle', '#666']; @endphp
                    <div style="margin-bottom: 14px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                            <span style="font-size: 12px; font-weight: 700;"><i class="fas {{ $m[1] }} me-1" style="color: {{ $m[2] }};"></i>{{ $m[0] }}</span>
                            <span style="font-size: 11px;"><strong style="color: {{ $m[2] }};">{{ number_format($data['actuel'] * 100, 1) }}%</strong> / {{ number_format($data['cible'] * 100, 0) }}%</span>
                        </div>
                        <div class="progress-5psl"><div class="progress-5psl-bar" style="width: {{ min($data['actuel'] * 100, 100) }}%; background: {{ $m[2] }};"></div></div>
                        <div style="font-size: 10px; color: var(--color-muted); margin-top: 3px;">{{ number_format($data['valeur'], 2, ',', ' ') }} $</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Financial Summary --}}
        <div class="card-5psl mt-3" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-chart-bar me-2" style="color: var(--possible-blue);"></i>Flux financiers</h4>
            </div>
            <div style="padding: 16px 24px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Total dépôts</span>
                    <span style="font-size: 13px; font-weight: 700; color: #059669;">+{{ number_format($totalDeposits, 2, ',', ' ') }} $</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Total retraits</span>
                    <span style="font-size: 13px; font-weight: 700; color: #dc2626;">-{{ number_format($totalWithdrawals, 2, ',', ' ') }} $</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Frais 2% perçus</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ number_format($totalFees, 2, ',', ' ') }} $</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span style="font-size: 12px; color: var(--color-muted);">Commissions HWM 30%</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ number_format($totalCommissions, 2, ',', ' ') }} $</span>
                </div>
            </div>
        </div>
    </div>

    {{-- KYC + Transactions Tables --}}
    <div class="col-lg-8">
        {{-- KYC Table --}}
        <div class="card-5psl mb-3 animate-fade-in-up delay-4" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <h4 style="font-size: 15px; font-weight: 800; margin: 0;">Vérifications KYC</h4>
                    @if(($pendingKycCount ?? 0) > 0)
                        <span class="badge-5psl badge-warning">{{ $pendingKycCount }}</span>
                    @else
                        <span class="badge-5psl badge-success">OK</span>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-5psl">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Email</th>
                            <th>Inscrit le</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingUsers ?? [] as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; flex-shrink: 0;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700;">{{ $user->name }}</div>
                                            <span class="tier-badge tier-{{ strtolower($user->tier ?? 'STARTER') }}" style="padding: 1px 6px; font-size: 8px;">{{ $user->tier ?? 'STARTER' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 13px;">{{ $user->email }}</td>
                                <td style="color: var(--color-muted); font-size: 13px;">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                        <form action="{{ route('admin.kyc.approve', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-possible btn-possible-xs" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                <i class="fas fa-check"></i> Approuver
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.kyc.reject', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-possible btn-possible-xs" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                <i class="fas fa-times"></i> Rejeter
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state" style="padding: 28px 20px;">
                                        <div class="empty-state-icon"><i class="fas fa-user-check"></i></div>
                                        <h4>Aucune vérification en attente</h4>
                                        <p>Tous les membres sont vérifiés.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="card-5psl animate-fade-in-up delay-5" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <h4 style="font-size: 15px; font-weight: 800; margin: 0;">Transactions en attente</h4>
                    @if(($pendingTransactionsCount ?? 0) > 0)
                        <span class="badge-5psl badge-warning">{{ $pendingTransactionsCount }}</span>
                    @else
                        <span class="badge-5psl badge-success">OK</span>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-5psl">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Net</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingTransactions ?? [] as $transaction)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 30px; height: 30px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; flex-shrink: 0;">
                                            {{ strtoupper(substr($transaction->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; font-size: 13px;">{{ $transaction->user->name }}</div>
                                            <span class="tier-badge tier-{{ strtolower($transaction->user->tier ?? 'STARTER') }}" style="padding: 1px 6px; font-size: 8px;">{{ $transaction->user->tier ?? 'STARTER' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($transaction->type === 'depot')
                                        <span class="badge-5psl badge-success"><i class="fas fa-arrow-down me-1"></i>Dépôt</span>
                                    @else
                                        <span class="badge-5psl badge-danger"><i class="fas fa-arrow-up me-1"></i>Retrait</span>
                                    @endif
                                </td>
                                <td class="text-mono" style="font-weight: 800; font-size: 13px;">{{ number_format((float)$transaction->montant, 2, ',', ' ') }} $</td>
                                <td class="text-mono" style="font-size: 12px; color: var(--color-warning);">{{ number_format((float)($transaction->frais_entree ?? 0), 2) }} $</td>
                                <td class="text-mono" style="font-size: 12px; color: var(--color-success); font-weight: 700;">{{ number_format((float)($transaction->montant_net ?? $transaction->montant), 2) }} $</td>
                                <td style="max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--color-muted); font-size: 12px;" title="{{ $transaction->description }}">
                                    {{ Str::limit($transaction->description ?? '—', 40) }}
                                </td>
                                <td style="color: var(--color-muted); font-size: 12px; white-space: nowrap;">{{ $transaction->created_at->format('d/m H:i') }}</td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                        <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-possible btn-possible-xs" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn-possible btn-possible-xs" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state" style="padding: 28px 20px;">
                                        <div class="empty-state-icon"><i class="fas fa-check-double"></i></div>
                                        <h4>Aucune transaction en attente</h4>
                                        <p>Toutes les transactions ont été traitées.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Approved --}}
        @if(isset($recentApproved) && $recentApproved->count() > 0)
        <div class="card-5psl mt-3 animate-fade-in-up delay-6" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-history me-2" style="color: var(--color-muted);"></i>Dernières validations</h4>
            </div>
            @foreach($recentApproved as $tx)
                <div style="padding: 12px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 28px; height: 28px; border-radius: 6px; background: {{ $tx->type === 'depot' ? '#ecfdf5' : '#fef2f2' }}; color: {{ $tx->type === 'depot' ? '#059669' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                            <i class="fas {{ $tx->type === 'depot' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        </div>
                        <div>
                            <span style="font-weight: 700; font-size: 13px;">{{ $tx->user->name ?? 'N/A' }}</span>
                            <span style="font-size: 11px; color: var(--color-muted);"> — {{ $tx->updated_at->format('d/m H:i') }}</span>
                        </div>
                    </div>
                    <span class="text-mono" style="font-weight: 800; font-size: 13px;">{{ number_format((float)$tx->montant, 2, ',', ' ') }} $</span>
                </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

@endsection
