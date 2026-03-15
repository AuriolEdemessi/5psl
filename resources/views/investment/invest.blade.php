@extends('layouts.dashboard')
@section('title', 'Investir')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Nouvel Investissement</h2>
        <p class="section-subtitle">Allouez vos fonds disponibles sur les actifs du club. Frais d'entrée de {{ $entryFeeRate }}%.</p>
    </div>
    <a href="{{ route('investment.dashboard') }}" class="btn-possible btn-possible-outline btn-possible-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

{{-- Balance & Info bar --}}
<div class="row g-3 mb-4">
    <div class="col-md-4 animate-fade-in-up delay-1">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 18px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <div class="info-item-label">Solde disponible</div>
                <div class="info-item-value text-mono">{{ number_format((float)$balance, 2, ',', ' ') }} $</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-2">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 18px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,0,0,0.04); color: var(--possible-dark); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <div class="info-item-label">NAV actuelle</div>
                <div class="info-item-value text-mono">{{ number_format((float)$nav, 4, ',', ' ') }} $</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-fade-in-up delay-3">
        <div class="card-5psl card-5psl-flat" style="display: flex; align-items: center; gap: 14px; padding: 18px;">
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0,0,0,0.04); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="tier-badge tier-{{ strtolower($tier) }}" style="padding: 3px 10px; font-size: 10px;">{{ $tier }}</span>
            </div>
            <div>
                <div class="info-item-label">Frais d'entrée</div>
                <div class="info-item-value">{{ $entryFeeRate }}%</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Form --}}
    <div class="col-lg-7 animate-fade-in-up delay-3">
        <div class="card-5psl">
            <form action="{{ route('investment.invest') }}" method="POST">
                @csrf

                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Sélectionnez l'actif</label>
                    <select name="asset_id" id="asset_id" class="input-5psl" required style="cursor: pointer;">
                        <option value="">Choisir un actif...</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" data-nav="{{ $asset->valeur_actuelle }}" data-cat="{{ $asset->categorie ?? 'securite' }}">
                                {{ $asset->nom }} — {{ ucfirst($asset->categorie ?? 'securite') }} ({{ number_format((float)$asset->valeur_actuelle, 2, ',', ' ') }} $)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Montant brut à investir (USD)</label>
                    <input type="number" name="montant" id="montant" class="input-5psl" step="0.01" min="1" required placeholder="Ex: 500">
                    @error('montant')
                        <div style="color: var(--color-danger); font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Estimation Panel --}}
                <div style="background: #f8fafc; border: 1.5px solid var(--color-border); border-radius: var(--radius); padding: 20px; margin-bottom: 28px;">
                    <div style="font-size: 11px; font-weight: 700; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">Estimation de votre investissement</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <div style="font-size: 11px; color: var(--color-muted); margin-bottom: 4px;">Frais ({{ $entryFeeRate }}%)</div>
                            <div id="est_fees" style="font-size: 18px; font-weight: 900; color: var(--color-warning);">0.00 $</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--color-muted); margin-bottom: 4px;">Montant net investi</div>
                            <div id="est_net" style="font-size: 18px; font-weight: 900; color: var(--color-success);">0.00 $</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--color-muted); margin-bottom: 4px;">NAV de l'actif</div>
                            <div id="est_nav" style="font-size: 18px; font-weight: 900; color: var(--possible-dark);">—</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--color-muted); margin-bottom: 4px;">Parts estimées</div>
                            <div id="est_parts" style="font-size: 18px; font-weight: 900; color: var(--possible-blue);">0.0000</div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 20px;">
                    <div style="font-size: 12px; color: var(--color-muted);">
                        <i class="fas fa-info-circle me-1"></i> Solde : <strong style="color: var(--possible-dark);">{{ number_format((float)$balance, 2, ',', ' ') }} $</strong>
                    </div>
                    <button type="submit" class="btn-possible btn-possible-primary">
                        <i class="fas fa-coins"></i> Confirmer l'investissement
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sidebar: Allocation Guide --}}
    <div class="col-lg-5 animate-slide-right delay-4">
        <div class="card-5psl" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-pie-chart me-2" style="color: var(--possible-blue);"></i>Répartition cible du club</h4>
            </div>
            <div style="padding: 20px 24px;">
                <div style="margin-bottom: 18px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 13px; font-weight: 700;"><i class="fas fa-shield-alt me-1" style="color: var(--possible-blue);"></i> Sécurité</span>
                        <span style="font-size: 12px; font-weight: 800; color: var(--possible-blue);">50%</span>
                    </div>
                    <div class="progress-5psl"><div class="progress-5psl-bar progress-5psl-blue" style="width: 50%;"></div></div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 4px;">Bons du Trésor, Obligations</div>
                </div>
                <div style="margin-bottom: 18px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 13px; font-weight: 700;"><i class="fas fa-chart-line me-1" style="color: var(--color-success);"></i> Croissance</span>
                        <span style="font-size: 12px; font-weight: 800; color: var(--color-success);">30%</span>
                    </div>
                    <div class="progress-5psl"><div class="progress-5psl-bar progress-5psl-green" style="width: 30%;"></div></div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 4px;">Actions, ETF</div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 13px; font-weight: 700;"><i class="fas fa-rocket me-1" style="color: var(--color-warning);"></i> Opportunités</span>
                        <span style="font-size: 12px; font-weight: 800; color: var(--color-warning);">20%</span>
                    </div>
                    <div class="progress-5psl"><div class="progress-5psl-bar progress-5psl-warning" style="width: 20%;"></div></div>
                    <div style="font-size: 11px; color: var(--color-muted); margin-top: 4px;">Crypto, Startups</div>
                </div>
            </div>
        </div>

        <div class="card-5psl mt-3" style="background: #f8fafc; border: 1px dashed var(--color-border);">
            <div style="display: flex; align-items: flex-start; gap: 12px;">
                <i class="fas fa-lightbulb" style="color: var(--color-warning); margin-top: 2px;"></i>
                <div style="font-size: 12px; color: var(--color-text); line-height: 1.6;">
                    <strong>Le saviez-vous ?</strong> Les parts sont calculées au moment de l'investissement selon la NAV courante. Votre nombre de parts reste fixe ; c'est la NAV qui évolue avec la performance des actifs.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const feeRate = {{ $entryFeeRate / 100 }};
    const globalNav = {{ (float)$nav }};

    document.addEventListener('DOMContentLoaded', function() {
        const assetSelect = document.getElementById('asset_id');
        const montantInput = document.getElementById('montant');

        function updateEstimation() {
            const selectedOption = assetSelect.options[assetSelect.selectedIndex];
            const assetNav = parseFloat(selectedOption.getAttribute('data-nav')) || 0;
            const montant = parseFloat(montantInput.value) || 0;

            const frais = (montant * feeRate);
            const net = montant - frais;
            const navUsed = assetNav > 0 ? assetNav : globalNav;
            const parts = navUsed > 0 ? net / navUsed : 0;

            document.getElementById('est_fees').textContent = frais.toFixed(2) + ' $';
            document.getElementById('est_net').textContent = net.toFixed(2) + ' $';
            document.getElementById('est_nav').textContent = assetNav > 0 ? assetNav.toFixed(4) + ' $' : '—';
            document.getElementById('est_parts').textContent = parts.toFixed(4);
        }

        assetSelect.addEventListener('change', updateEstimation);
        montantInput.addEventListener('input', updateEstimation);
    });
</script>
@endsection
