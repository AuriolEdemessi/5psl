@extends('layouts.dashboard')
@section('title', 'Affiliation')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Programme d'Affiliation</h2>
        <p class="section-subtitle">Parrainez de nouveaux membres et recevez 10% de la commission de performance sur leurs gains.</p>
    </div>
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-fade-in-up delay-1">
        <div class="card-5psl card-gradient-dark" style="padding: 24px;">
            <div class="kpi-label" style="color: rgba(255,255,255,0.5);">Gains cumulés</div>
            <div class="kpi-value text-mono" style="color: #4ade80; font-size: 28px;">{{ number_format((float)$totalEarnings, 2, ',', ' ') }} <span style="font-size: 14px; opacity: 0.6;">$</span></div>
            <div style="font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 6px;">10% de la commission gestionnaire de vos filleuls</div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-2">
        <div class="card-5psl kpi-card">
            <div class="kpi-label">Filleuls actifs</div>
            <div class="kpi-value">{{ $referralCount }}</div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-3">
        <div class="card-5psl kpi-card">
            <div class="kpi-label">Transactions générées</div>
            <div class="kpi-value">{{ $earnings->count() }}</div>
        </div>
    </div>
</div>

{{-- Referral link card --}}
<div class="card-5psl mb-4 animate-fade-in-up delay-2" style="border: 2px solid var(--possible-blue); background: rgba(0,102,255,0.02);">
    <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 16px;"><i class="fas fa-link me-2" style="color: var(--possible-blue);"></i>Votre lien de parrainage</h4>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <div class="crypto-address-box" style="flex: 1; min-width: 300px;">
            <code id="referralLink" style="font-size: 13px; word-break: break-all;">{{ $referralLink }}</code>
        </div>
        <button type="button" onclick="copyToClipboard('{{ $referralLink }}', this)" class="btn-possible btn-possible-primary btn-possible-sm">
            <i class="fas fa-copy me-1"></i> Copier
        </button>
    </div>
    <div style="margin-top: 12px; font-size: 12px; color: var(--color-muted); display: flex; align-items: center; gap: 8px;">
        <span style="background: rgba(0,102,255,0.08); color: var(--possible-blue); padding: 3px 8px; border-radius: 4px; font-weight: 700; font-size: 11px;">Code : {{ $referralCode }}</span>
        <span>Partagez ce lien pour que vos filleuls s'inscrivent automatiquement sous votre parrainage.</span>
    </div>
</div>

{{-- How it works --}}
<div class="card-5psl mb-4 animate-fade-in-up delay-3" style="background: #f8fafc; border: 1px dashed var(--color-border);">
    <h4 style="font-size: 14px; font-weight: 800; margin-bottom: 16px;"><i class="fas fa-info-circle me-2" style="color: var(--possible-blue);"></i>Comment ça fonctionne</h4>
    <div class="row g-3">
        <div class="col-md-4">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0;">1</div>
                <div>
                    <div style="font-size: 13px; font-weight: 700;">Partagez votre lien</div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 2px;">Votre filleul s'inscrit via votre lien unique.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0;">2</div>
                <div>
                    <div style="font-size: 13px; font-weight: 700;">Il investit et génère des gains</div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 2px;">La commission gestionnaire (30%) est calculée sur ses plus-values.</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
                <div style="width: 32px; height: 32px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0;">$</div>
                <div>
                    <div style="font-size: 13px; font-weight: 700;">Vous recevez 10%</div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 2px;">10% de la commission gestionnaire est créditée sur votre compte.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Referrals list --}}
    <div class="col-lg-5 animate-fade-in-up delay-4">
        <div class="card-5psl" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-users me-2" style="color: var(--possible-blue);"></i>Mes Filleuls</h4>
            </div>
            @forelse($referrals as $ref)
                <div style="padding: 12px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px;">
                        {{ strtoupper(substr($ref->name, 0, 1)) }}
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 13px;">{{ $ref->name }}</div>
                        <div style="font-size: 11px; color: var(--color-muted);">Inscrit {{ $ref->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="tier-badge tier-{{ strtolower($ref->tier ?? 'starter') }}" style="font-size: 9px;">{{ $ref->tier ?? 'STARTER' }}</span>
                </div>
            @empty
                <div class="empty-state" style="padding: 32px 20px;">
                    <div class="empty-state-icon"><i class="fas fa-user-plus"></i></div>
                    <h4>Aucun filleul</h4>
                    <p>Partagez votre lien pour commencer.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Earnings history --}}
    <div class="col-lg-7 animate-fade-in-up delay-5">
        <div class="card-5psl" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-receipt me-2" style="color: #059669;"></i>Historique des gains</h4>
            </div>
            <div class="table-responsive">
                <table class="table-5psl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Filleul</th>
                            <th>Commission gestionnaire</th>
                            <th>Votre gain (10%)</th>
                            <th>NAV</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($earnings as $e)
                            <tr>
                                <td style="font-size: 12px; color: var(--color-muted);">{{ $e->created_at->format('d/m/Y') }}</td>
                                <td style="font-weight: 700; font-size: 13px;">{{ $e->referred->name ?? '—' }}</td>
                                <td class="text-mono" style="font-size: 12px;">{{ number_format((float)$e->manager_commission, 2, ',', ' ') }} $</td>
                                <td class="text-mono" style="font-weight: 800; color: #059669;">+{{ number_format((float)$e->affiliate_amount, 2, ',', ' ') }} $</td>
                                <td class="text-mono" style="font-size: 12px; color: var(--color-muted);">{{ number_format((float)$e->nav_at_time, 4, ',', ' ') }} $</td>
                                <td>
                                    @if($e->status === 'credited')
                                        <span class="badge-5psl badge-success">Crédité</span>
                                    @elseif($e->status === 'paid')
                                        <span class="badge-5psl badge-info">Payé</span>
                                    @else
                                        <span class="badge-5psl badge-warning">En attente</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state" style="padding: 32px 20px;">
                                        <div class="empty-state-icon"><i class="fas fa-chart-line"></i></div>
                                        <h4>Aucun gain</h4>
                                        <p>Les gains apparaîtront ici lorsque vos filleuls généreront des plus-values.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
