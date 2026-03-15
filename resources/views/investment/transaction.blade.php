@extends('layouts.dashboard')
@section('title', 'Dépôt / Retrait')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Nouvelle Transaction</h2>
        <p class="section-subtitle">Envoyez des USDT ou USDC pour déposer, ou indiquez votre adresse pour retirer.</p>
    </div>
    <a href="{{ route('investment.dashboard') }}" class="btn-possible btn-possible-outline btn-possible-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

{{-- Balance & Withdrawal Info --}}
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
            <div style="width: 40px; height: 40px; border-radius: 10px; background: {{ $withdrawable['can_withdraw'] ? '#ecfdf5' : '#fffbeb' }}; color: {{ $withdrawable['can_withdraw'] ? '#059669' : '#d97706' }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas {{ $withdrawable['can_withdraw'] ? 'fa-check-circle' : 'fa-clock' }}"></i>
            </div>
            <div>
                <div class="info-item-label">Gains retirables</div>
                <div class="info-item-value text-mono" style="color: {{ $withdrawable['can_withdraw'] ? '#059669' : '#d97706' }};">
                    {{ number_format($withdrawable['montant_retirable'], 2, ',', ' ') }} $
                </div>
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
                <div class="info-item-value">{{ $entryFeeRate }}% <span style="font-size: 11px; color: var(--color-muted); font-weight: 600;">sur les dépôts</span></div>
            </div>
        </div>
    </div>
</div>

@if(!$withdrawable['can_withdraw'])
<div class="alert-5psl alert-5psl-warning animate-fade-in-up delay-2" style="margin-bottom: 20px;">
    <i class="fas fa-hourglass-half"></i>
    Fenêtre de retrait des gains dans <strong>{{ $withdrawable['days_remaining'] }} jour(s)</strong>. Les retraits de gains ne sont possibles que tous les 30 jours.
</div>
@endif

<div class="row g-3">
    {{-- Form --}}
    <div class="col-lg-7 animate-fade-in-up delay-3">
        <div class="card-5psl">
            <form action="{{ route('investment.transaction.store') }}" method="POST" id="transactionForm">
                @csrf

                {{-- Type selector --}}
                <div style="display: flex; gap: 12px; margin-bottom: 24px;">
                    <label id="label_depot" style="flex: 1; cursor: pointer; border: 2px solid var(--color-border); padding: 18px; border-radius: var(--radius); display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                        <input type="radio" name="type" id="type_depot" value="depot" required style="accent-color: var(--possible-blue); width: 18px; height: 18px;" onchange="switchType()">
                        <div>
                            <div style="font-weight: 800; font-size: 14px;">Dépôt</div>
                            <div style="font-size: 11px; color: var(--color-muted);">Envoyer USDT/USDC</div>
                        </div>
                    </label>
                    <label id="label_retrait" style="flex: 1; cursor: pointer; border: 2px solid var(--color-border); padding: 18px; border-radius: var(--radius); display: flex; align-items: center; gap: 12px; transition: all 0.3s;">
                        <input type="radio" name="type" id="type_retrait" value="retrait" required style="accent-color: var(--possible-dark); width: 18px; height: 18px;" onchange="switchType()">
                        <div>
                            <div style="font-weight: 800; font-size: 14px;">Retrait</div>
                            <div style="font-size: 11px; color: var(--color-muted);">Recevoir sur votre wallet</div>
                        </div>
                    </label>
                </div>

                {{-- Depot instructions --}}
                <div id="section_depot" style="display: none;">
                    <div class="alert-5psl alert-5psl-info" style="margin-bottom: 20px;">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Comment déposer ?</strong> Envoyez vos USDT ou USDC à l'une des adresses ci-dessous, puis remplissez ce formulaire. Votre dépôt sera crédité après confirmation (sous 24h).
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label-custom">Sélectionnez le réseau</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;" id="networkPills">
                            @foreach($cryptoAddresses as $i => $crypto)
                                <button type="button" class="network-pill" onclick="selectNetwork({{ $i }}, this)" data-index="{{ $i }}">
                                    <strong>{{ $crypto['coin'] }}</strong> {{ $crypto['network'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div id="selectedAddress" style="display: none; margin-bottom: 20px;">
                        <label class="form-label-custom">Adresse de dépôt du club</label>
                        <div class="crypto-address-box" id="cryptoAddressDisplay">
                            <span id="addressText"></span>
                            <button type="button" class="crypto-copy-btn" onclick="copyToClipboard(document.getElementById('addressText').textContent, this)">Copier</button>
                        </div>
                        <input type="hidden" name="crypto_network" id="cryptoNetworkInput">
                        <p style="font-size: 11px; color: var(--color-warning); margin-top: 8px; font-weight: 600;">
                            <i class="fas fa-exclamation-triangle me-1"></i> Envoyez uniquement sur le bon réseau. Tout envoi sur un mauvais réseau peut entraîner une perte de fonds.
                        </p>
                    </div>
                </div>

                {{-- Retrait instructions --}}
                <div id="section_retrait" style="display: none;">
                    <div class="alert-5psl alert-5psl-warning" style="margin-bottom: 20px;">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Retrait de gains uniquement.</strong> Vous ne pouvez retirer que vos plus-values. La commission de 30% (High-Water Mark) sera prélevée sur les gains au-delà de votre sommet historique.
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label-custom">Votre adresse de réception (USDT/USDC)</label>
                        <input type="text" name="crypto_address" class="input-5psl" placeholder="Ex: 0x... ou T... (collez votre adresse wallet)" style="font-family: monospace;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label class="form-label-custom">Réseau souhaité</label>
                        <select name="crypto_network" class="input-5psl" style="cursor: pointer;">
                            <option value="">Choisir le réseau...</option>
                            <option value="TRC20 (Tron)">USDT — TRC20 (Tron)</option>
                            <option value="ERC20 (Ethereum)">USDT/USDC — ERC20 (Ethereum)</option>
                            <option value="BEP20 (BSC)">USDT/USDC — BEP20 (BSC)</option>
                            <option value="SOL (Solana)">USDC — SOL (Solana)</option>
                        </select>
                    </div>
                </div>

                {{-- Montant --}}
                <div style="margin-bottom: 20px;">
                    <label class="form-label-custom">Montant (USD)</label>
                    <input type="number" name="montant" id="montantInput" class="input-5psl @error('montant') is-invalid @enderror" value="{{ old('montant') }}" step="0.01" min="1" required placeholder="Ex: 500">
                    @error('montant')
                        <div style="color: var(--color-danger); font-size: 12px; margin-top: 6px; font-weight: 600;">{{ $message }}</div>
                    @enderror
                    <div id="feePreview" style="display: none; margin-top: 8px; font-size: 12px; color: var(--color-muted);">
                        Frais {{ $entryFeeRate }}% : <strong id="feeAmount" style="color: var(--color-warning);">0.00 $</strong>
                        — Net crédité : <strong id="netAmount" style="color: var(--color-success);">0.00 $</strong>
                    </div>
                </div>

                {{-- Description --}}
                <div style="margin-bottom: 24px;">
                    <label class="form-label-custom">Notes / Informations complémentaires</label>
                    <textarea name="description" class="input-5psl" rows="2" placeholder="Référence de transaction, hash de la transaction crypto..."></textarea>
                </div>

                {{-- Submit --}}
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 20px;">
                    <div style="font-size: 12px; color: var(--color-muted);">
                        <i class="fas fa-shield-alt me-1"></i> Validation manuelle par l'admin
                    </div>
                    <button type="submit" class="btn-possible btn-possible-primary">
                        <i class="fas fa-paper-plane"></i> Soumettre
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Right Sidebar: Help & Buy Crypto --}}
    <div class="col-lg-5 animate-slide-right delay-4">
        {{-- Buy Crypto --}}
        <div class="card-5psl card-gradient-blue mb-3" style="padding: 24px;">
            <div style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                    <i class="fas fa-cart-shopping"></i>
                </div>
                <div>
                    <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 6px;">Pas de crypto ?</h4>
                    <p style="font-size: 13px; opacity: 0.8; margin-bottom: 16px; line-height: 1.5;">Achetez vos USDT ou USDC directement via notre service d'accompagnement. Nous vous guidons pas à pas.</p>
                    <a href="https://wa.me/22500000000?text=Bonjour%2C%20je%20souhaite%20acheter%20des%20USDT%20pour%20d%C3%A9poser%20sur%205PSL" target="_blank" class="btn-possible btn-possible-sm" style="background: white; color: var(--possible-blue);">
                        <i class="fab fa-whatsapp"></i> Acheter via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="card-5psl" style="padding: 0; overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-circle-question me-2" style="color: var(--possible-blue);"></i>Comment ça marche ?</h4>
            </div>
            <div style="padding: 20px 24px;">
                <div style="display: flex; gap: 14px; margin-bottom: 18px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--possible-light-blue); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0;">1</div>
                    <div>
                        <div style="font-weight: 700; font-size: 13px;">Dépôt</div>
                        <div style="font-size: 12px; color: var(--color-muted); line-height: 1.5;">Envoyez vos USDT/USDC à l'adresse affichée. Sélectionnez le bon réseau.</div>
                    </div>
                </div>
                <div style="display: flex; gap: 14px; margin-bottom: 18px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--possible-light-blue); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0;">2</div>
                    <div>
                        <div style="font-weight: 700; font-size: 13px;">Confirmation</div>
                        <div style="font-size: 12px; color: var(--color-muted); line-height: 1.5;">Un admin vérifie la réception et crédite votre compte (frais de {{ $entryFeeRate }}% déduits).</div>
                    </div>
                </div>
                <div style="display: flex; gap: 14px; margin-bottom: 18px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--possible-light-blue); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0;">3</div>
                    <div>
                        <div style="font-weight: 700; font-size: 13px;">Retrait</div>
                        <div style="font-size: 12px; color: var(--color-muted); line-height: 1.5;">Retirez vos gains tous les 30 jours. Commission HWM de 30% sur les plus-values uniquement.</div>
                    </div>
                </div>
                <div style="display: flex; gap: 14px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; flex-shrink: 0;"><i class="fas fa-check" style="font-size: 10px;"></i></div>
                    <div>
                        <div style="font-weight: 700; font-size: 13px;">Envoi sur votre wallet</div>
                        <div style="font-size: 12px; color: var(--color-muted); line-height: 1.5;">Les fonds sont envoyés à l'adresse que vous avez fournie après validation.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const cryptoAddresses = @json($cryptoAddresses);
    const feeRate = {{ $entryFeeRate / 100 }};

    function switchType() {
        const isDepot = document.getElementById('type_depot').checked;
        const isRetrait = document.getElementById('type_retrait').checked;

        document.getElementById('label_depot').style.borderColor = isDepot ? 'var(--possible-blue)' : 'var(--color-border)';
        document.getElementById('label_depot').style.background = isDepot ? 'var(--possible-light-blue)' : 'transparent';
        document.getElementById('label_retrait').style.borderColor = isRetrait ? 'var(--possible-dark)' : 'var(--color-border)';
        document.getElementById('label_retrait').style.background = isRetrait ? 'rgba(0,0,0,0.02)' : 'transparent';

        document.getElementById('section_depot').style.display = isDepot ? 'block' : 'none';
        document.getElementById('section_retrait').style.display = isRetrait ? 'block' : 'none';
        document.getElementById('feePreview').style.display = isDepot ? 'block' : 'none';
        updateFeePreview();
    }

    function selectNetwork(index, el) {
        document.querySelectorAll('.network-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        const addr = cryptoAddresses[index];
        document.getElementById('addressText').textContent = addr.address;
        document.getElementById('cryptoNetworkInput').value = addr.coin + ' - ' + addr.network;
        document.getElementById('selectedAddress').style.display = 'block';
    }

    function updateFeePreview() {
        const montant = parseFloat(document.getElementById('montantInput').value) || 0;
        const frais = (montant * feeRate).toFixed(2);
        const net = (montant - frais).toFixed(2);
        document.getElementById('feeAmount').textContent = frais + ' $';
        document.getElementById('netAmount').textContent = net + ' $';
    }

    document.getElementById('montantInput').addEventListener('input', updateFeePreview);

    // Init on load
    if(document.getElementById('type_depot').checked || document.getElementById('type_retrait').checked) {
        switchType();
    }
</script>
@endsection
