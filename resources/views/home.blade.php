@extends('layouts.dashboard')
@section('title', 'Accueil')

@section('content')

@php $user = Auth::user(); @endphp

{{-- Welcome Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
            <h2 class="section-title-sm" style="margin: 0;">Bonjour, {{ $user->name }}</h2>
            <span class="tier-badge tier-{{ strtolower($tier) }}"><i class="fas fa-crown" style="font-size: 9px;"></i> {{ $tier }}</span>
        </div>
        <p class="section-subtitle">Retrouvez ici l'essentiel de votre compte et de vos investissements.</p>
    </div>
</div>

{{-- Portfolio Snapshot --}}
<div class="card-5psl card-gradient-dark mb-4 animate-fade-in-up delay-1" style="padding: 28px 32px;">
    <div class="row align-items-center">
        <div class="col-md-4" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Valeur du portefeuille</div>
            <div style="font-size: 30px; font-weight: 900; letter-spacing: -1px;" class="text-mono">{{ number_format((float)$portfolioValue, 2, ',', ' ') }} <span style="font-size: 14px; opacity: 0.6;">$</span></div>
        </div>
        <div class="col-md-3 text-center" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">Solde disponible</div>
            <div style="font-size: 22px; font-weight: 900;" class="text-mono">{{ number_format((float)$balance, 2, ',', ' ') }} $</div>
        </div>
        <div class="col-md-3 text-center" style="border-right: 1px solid rgba(255,255,255,0.1);">
            <div style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; margin-bottom: 6px;">ROI</div>
            <div style="font-size: 22px; font-weight: 900; color: {{ (float)$roi >= 0 ? '#4ade80' : '#f87171' }};">
                {{ (float)$roi >= 0 ? '+' : '' }}{{ number_format((float)$roi, 2, ',', ' ') }}%
            </div>
        </div>
        <div class="col-md-2 text-center">
            <a href="{{ route('investment.dashboard') }}" class="btn-possible btn-possible-sm" style="background: white; color: var(--possible-dark); width: 100%; justify-content: center;">
                Portfolio <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

{{-- Account Info Bar --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-fade-in-up delay-2">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 20px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div class="info-item-label">Rôle</div>
                <div class="info-item-value">{{ $user->role === 'admin' ? 'Administrateur' : 'Membre' }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-3">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 20px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;
                @if($user->kyc_status === 'verified') background: #ecfdf5; color: #059669;
                @elseif($user->kyc_status === 'rejected') background: #fef2f2; color: #dc2626;
                @else background: #fffbeb; color: #d97706; @endif">
                @if($user->kyc_status === 'verified') <i class="fas fa-check-circle"></i>
                @elseif($user->kyc_status === 'rejected') <i class="fas fa-times-circle"></i>
                @else <i class="fas fa-clock"></i> @endif
            </div>
            <div>
                <div class="info-item-label">Statut KYC</div>
                <div class="info-item-value" style="
                    @if($user->kyc_status === 'verified') color: #059669;
                    @elseif($user->kyc_status === 'rejected') color: #dc2626;
                    @else color: #d97706; @endif">
                    @if($user->kyc_status === 'verified') Vérifié
                    @elseif($user->kyc_status === 'rejected') Rejeté
                    @else En attente @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-4">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 20px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,0,0,0.04); color: var(--possible-dark); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <div class="info-item-label">Membre depuis</div>
                <div class="info-item-value">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Main Feature Cards + Recent Transactions --}}
<div class="row g-3">
    <div class="col-lg-4 animate-fade-in-up delay-4">
        <div class="card-5psl card-gradient-blue" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between; padding: 28px;">
            <div>
                <div style="width: 44px; height: 44px; background: rgba(255,255,255,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">Club d'Investissement</h3>
                <p style="font-size: 13px; opacity: 0.7; margin-bottom: 24px; line-height: 1.6;">Gérez votre portefeuille, votez pour les opportunités et suivez vos rendements.</p>
            </div>
            <a href="{{ route('investment.dashboard') }}" class="btn-possible btn-possible-sm" style="background: white; color: var(--possible-blue); width: 100%; justify-content: center;">
                Accéder au Portfolio <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 animate-fade-in-up delay-5">
        <div class="card-5psl" style="border: 1.5px solid var(--possible-blue); height: 100%; display: flex; flex-direction: column; justify-content: space-between; padding: 28px;">
            <div>
                <div style="width: 44px; height: 44px; background: rgba(0,102,255,0.08); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 18px; color: var(--possible-blue);">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; color: var(--possible-dark); margin-bottom: 8px;">Mes Formations</h3>
                <p style="font-size: 13px; color: var(--color-muted); margin-bottom: 24px; line-height: 1.6;">Finance, crypto, immobilier via nos programmes exclusifs.</p>
            </div>
            <a href="{{ route('courses.index') }}" class="btn-possible btn-possible-primary btn-possible-sm" style="width: 100%; justify-content: center;">
                Reprendre mes cours <i class="fas fa-play ms-2"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 animate-slide-right delay-5">
        <div class="card-5psl" style="padding: 0; overflow: hidden; height: 100%; display: flex; flex-direction: column;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;">Dernières transactions</h4>
                <a href="{{ route('investment.transaction.form') }}" style="font-size: 11px; font-weight: 700; color: var(--possible-blue);">Voir tout</a>
            </div>
            <div style="flex: 1;">
                @forelse($recentTransactions ?? [] as $tx)
                    <div style="padding: 12px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 30px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px;
                                background: {{ $tx->type === 'depot' ? '#ecfdf5' : '#fef2f2' }};
                                color: {{ $tx->type === 'depot' ? '#059669' : '#dc2626' }};">
                                <i class="fas {{ $tx->type === 'depot' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; font-size: 12px;">{{ $tx->type === 'depot' ? 'Dépôt' : 'Retrait' }}</div>
                                <div style="font-size: 10px; color: var(--color-muted);">{{ $tx->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div class="text-mono" style="font-weight: 800; font-size: 12px; color: {{ $tx->type === 'depot' ? '#059669' : '#121212' }};">
                                {{ $tx->type === 'depot' ? '+' : '-' }}{{ number_format((float)$tx->montant, 2, ',', ' ') }} $
                            </div>
                            @if(in_array($tx->statut, ['valide', 'approuve']))
                                <span class="badge-5psl badge-success" style="font-size: 8px; padding: 2px 6px;">Validé</span>
                            @elseif($tx->statut === 'en_attente')
                                <span class="badge-5psl badge-warning" style="font-size: 8px; padding: 2px 6px;">En attente</span>
                            @else
                                <span class="badge-5psl badge-danger" style="font-size: 8px; padding: 2px 6px;">Rejeté</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="padding: 28px 16px;">
                        <div class="empty-state-icon" style="width: 44px; height: 44px;"><i class="fas fa-receipt" style="font-size: 18px;"></i></div>
                        <h4 style="font-size: 13px;">Aucune transaction</h4>
                        <p style="font-size: 11px;">Commencez par un dépôt USDT/USDC.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
