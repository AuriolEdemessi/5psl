@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-end">
    <div class="col-sm mb-2 mb-sm-0">
      <h1 class="page-header-title">Administration du Club</h1>
      <p class="page-header-text">Vue d'ensemble, gestion des membres, validation des transactions.</p>
    </div>
  </div>
</div>

<!-- Quick Actions Bar -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card card-body">
      <div class="row align-items-center">
        <div class="col">
          <h5 class="mb-0"><i class="bi-lightning-charge text-warning me-2"></i>Actions rapides</h5>
        </div>
        <div class="col-auto d-flex gap-2 flex-wrap">
          <a class="btn btn-primary btn-sm" href="{{ route('opportunities.create') }}">
            <i class="bi-plus-circle me-1"></i> Nouvelle Opportunité
          </a>
          <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.users.create') }}">
            <i class="bi-person-plus me-1"></i> Créer un membre
          </a>
          <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.assets.index') }}">
            <i class="bi-briefcase me-1"></i> Gérer les actifs
          </a>
          <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.crypto.index') }}">
            <i class="bi-currency-bitcoin me-1"></i> Adresses dépôts
          </a>
          <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.kyc.index') }}">
            <i class="bi-person-check me-1"></i> KYC détaillé
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stats Banner -->
<div class="row mb-4">
  <div class="col-12">
    <div class="card bg-dark text-white text-center p-4">
      <div class="row align-items-center">
        <div class="col-md-4 mb-3 mb-md-0 border-md-end border-white-10">
          <h6 class="text-white-50 text-uppercase mb-1">Actifs sous gestion (AUM)</h6>
          <h2 class="text-white display-4 mb-0">{{ number_format($totalAUM, 2, ',', ' ') }} <span class="fs-6 text-white-50">$</span></h2>
        </div>
        <div class="col-md-2 mb-3 mb-md-0 border-md-end border-white-10">
          <h6 class="text-white-50 text-uppercase mb-1">NAV / Part</h6>
          <h3 class="text-white mb-0">{{ number_format((float)$nav, 4, ',', ' ') }}</h3>
        </div>
        <div class="col-md-2 mb-3 mb-md-0 border-md-end border-white-10">
          <h6 class="text-white-50 text-uppercase mb-1">Parts totales</h6>
          <h3 class="text-white mb-0">{{ number_format($totalShares, 2, ',', ' ') }}</h3>
        </div>
        <div class="col-md-2 mb-3 mb-md-0 border-md-end border-white-10">
          <h6 class="text-white-50 text-uppercase mb-1">Membres</h6>
          <h3 class="text-white mb-0">{{ $totalMembers }}</h3>
        </div>
        <div class="col-md-2">
          <h6 class="text-white-50 text-uppercase mb-1">Opportunités</h6>
          <h3 class="text-white mb-0">{{ $activeOpportunitiesCount }}</h3>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">KYC en attente</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 {{ ($pendingKycCount ?? 0) > 0 ? 'text-warning' : 'text-success' }}">{{ $pendingKycCount ?? 0 }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-primary icon-circle"><i class="bi-person-badge"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Transactions en attente</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 {{ ($pendingTransactionsCount ?? 0) > 0 ? 'text-warning' : 'text-success' }}">{{ $pendingTransactionsCount ?? 0 }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-warning icon-circle"><i class="bi-hourglass-split"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Total Frais perçus</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-dark">{{ number_format($totalFees, 2, ',', ' ') }} <span class="fs-6 text-muted">$</span></span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-success icon-circle"><i class="bi-cash-stack"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Commissions HWM</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-dark">{{ number_format($totalCommissions, 2, ',', ' ') }} <span class="fs-6 text-muted">$</span></span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-info icon-circle"><i class="bi-percent"></i></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====== PENDING TRANSACTIONS (Priority Section) ====== -->
<div class="card mb-4">
  <div class="card-header card-header-content-between">
    <h4 class="card-header-title">
      <i class="bi-hourglass-split text-warning me-2"></i>Transactions en attente
      @if(($pendingTransactionsCount ?? 0) > 0)
        <span class="badge bg-soft-warning text-warning ms-2">{{ $pendingTransactionsCount }} à traiter</span>
      @else
        <span class="badge bg-soft-success text-success ms-2">Tout est à jour</span>
      @endif
    </h4>
  </div>
  <div class="card-body p-0">
    @forelse($pendingTransactions ?? [] as $transaction)
      <div class="border-bottom p-4 {{ $loop->even ? 'bg-light' : '' }}">
        <div class="row align-items-center">
          {{-- User info --}}
          <div class="col-lg-3 mb-3 mb-lg-0">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm avatar-soft-{{ $transaction->type === 'depot' ? 'success' : 'danger' }} avatar-circle me-3">
                <span class="avatar-initials">{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</span>
              </div>
              <div>
                <h5 class="mb-0">{{ $transaction->user->name }}</h5>
                <span class="badge bg-info rounded-pill" style="font-size: 0.6rem;">{{ $transaction->user->tier ?? 'STARTER' }}</span>
                <span class="d-block text-muted small">{{ $transaction->user->email }}</span>
              </div>
            </div>
          </div>
          {{-- Transaction details --}}
          <div class="col-lg-5 mb-3 mb-lg-0">
            <div class="row text-center">
              <div class="col-4">
                <span class="d-block text-muted small text-uppercase">Type</span>
                @if($transaction->type === 'depot')
                  <span class="badge bg-success px-3 py-2"><i class="bi-arrow-down-short me-1"></i>Dépôt</span>
                @else
                  <span class="badge bg-danger px-3 py-2"><i class="bi-arrow-up-short me-1"></i>Retrait</span>
                @endif
              </div>
              <div class="col-4">
                <span class="d-block text-muted small text-uppercase">Montant brut</span>
                <span class="fw-bold fs-5">{{ number_format((float)$transaction->montant, 2, ',', ' ') }} $</span>
              </div>
              <div class="col-4">
                <span class="d-block text-muted small text-uppercase">Montant net</span>
                <span class="fw-bold fs-5 text-success">{{ number_format((float)($transaction->montant_net ?? $transaction->montant), 2, ',', ' ') }} $</span>
              </div>
            </div>
            @if($transaction->description)
              <div class="mt-2 p-2 bg-soft-dark rounded small">
                <i class="bi-info-circle text-muted me-1"></i>{{ $transaction->description }}
              </div>
            @endif
            <div class="mt-1 text-muted small"><i class="bi-clock me-1"></i>{{ $transaction->created_at->format('d/m/Y à H:i') }}
              @if($transaction->frais_entree > 0)
                · Frais 2% : {{ number_format((float)$transaction->frais_entree, 2, ',', ' ') }} $
              @endif
            </div>
          </div>
          {{-- Action Buttons --}}
          <div class="col-lg-4 text-lg-end">
            <div class="d-flex gap-2 justify-content-lg-end">
              <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="d-inline js-confirm" data-msg="Confirmer la validation de ce {{ $transaction->type === 'depot' ? 'dépôt' : 'retrait' }} de {{ number_format((float)$transaction->montant, 2, ',', ' ') }} $ pour {{ $transaction->user->name }} ?">
                @csrf
                <button type="submit" class="btn btn-success">
                  <i class="bi-check-circle me-1"></i> Valider
                </button>
              </form>
              <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="d-inline js-confirm" data-msg="Rejeter cette transaction de {{ $transaction->user->name }} ?">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                  <i class="bi-x-circle me-1"></i> Rejeter
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="text-center py-5">
        <div class="mb-3"><i class="bi-check2-all fs-1 text-success"></i></div>
        <h5>Aucune transaction en attente</h5>
        <p class="text-muted mb-0">Toutes les transactions ont été traitées.</p>
      </div>
    @endforelse
  </div>
</div>

<div class="row mb-4">
  <!-- Left Column -->
  <div class="col-lg-4 mb-4 mb-lg-0">
    
    <!-- Tier Breakdown -->
    <div class="card mb-3">
      <div class="card-header">
        <h4 class="card-header-title"><i class="bi-layers text-primary me-2"></i> Répartition par palier</h4>
      </div>
      <div class="card-body">
        @php
            $tierColors = ['STARTER' => 'bg-info', 'PRO' => 'bg-warning', 'ELITE' => 'bg-primary'];
            $tierTotal = max(array_sum($tierBreakdown), 1);
        @endphp
        @foreach($tierBreakdown as $tierName => $count)
            @php $tc = $tierColors[$tierName] ?? 'bg-secondary'; @endphp
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div><span class="badge {{ $tc }} text-white">{{ $tierName }}</span></div>
              <div class="d-flex align-items-center">
                <div class="progress me-2" style="width: 60px; height: 6px;">
                  <div class="progress-bar {{ $tc }}" role="progressbar" style="width: {{ ($count / $tierTotal) * 100 }}%;"></div>
                </div>
                <span class="fw-bold">{{ $count }}</span>
              </div>
            </div>
        @endforeach
      </div>
    </div>

    <!-- Portfolio Allocation -->
    @if(!empty($allocation))
    <div class="card mb-3">
      <div class="card-header">
        <h4 class="card-header-title"><i class="bi-pie-chart text-primary me-2"></i> Allocation (50/30/20)</h4>
      </div>
      <div class="card-body">
        @php
            $catMeta = [
                'securite' => ['Sécurité', 'bi-shield-check', 'bg-primary', 'text-primary'], 
                'croissance' => ['Croissance', 'bi-graph-up-arrow', 'bg-success', 'text-success'], 
                'opportunite' => ['Opportunités', 'bi-rocket', 'bg-warning', 'text-warning']
            ];
        @endphp
        @foreach($allocation as $cat => $data)
            @php $m = $catMeta[$cat] ?? ['Autre', 'bi-circle', 'bg-secondary', 'text-secondary']; @endphp
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fs-6 fw-bold"><i class="{{ $m[1] }} {{ $m[3] }} me-1"></i>{{ $m[0] }}</span>
                    <span class="fs-6"><strong class="{{ $m[3] }}">{{ number_format($data['actuel'] * 100, 1) }}%</strong> / {{ number_format($data['cible'] * 100, 0) }}%</span>
                </div>
                <div class="progress mb-1" style="height: 6px;">
                    <div class="progress-bar {{ $m[2] }}" role="progressbar" style="width: {{ min($data['actuel'] * 100, 100) }}%;"></div>
                </div>
                <div class="small text-muted">{{ number_format($data['valeur'], 2, ',', ' ') }} $</div>
            </div>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Financial Summary -->
    <div class="card">
      <div class="card-header">
        <h4 class="card-header-title"><i class="bi-bar-chart text-primary me-2"></i> Flux financiers</h4>
      </div>
      <div class="card-body">
        <ul class="list-group list-group-flush list-group-no-gutters">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="text-muted">Total dépôts</span>
            <span class="fw-bold text-success">+{{ number_format($totalDeposits, 2, ',', ' ') }} $</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="text-muted">Total retraits</span>
            <span class="fw-bold text-danger">-{{ number_format($totalWithdrawals, 2, ',', ' ') }} $</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="text-muted">Frais 2% perçus</span>
            <span class="fw-bold">{{ number_format($totalFees, 2, ',', ' ') }} $</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="text-muted">Commissions HWM 30%</span>
            <span class="fw-bold">{{ number_format($totalCommissions, 2, ',', ' ') }} $</span>
          </li>
        </ul>
      </div>
    </div>

  </div>

  <!-- Right Column -->
  <div class="col-lg-8">
    
    <!-- KYC Pending -->
    <div class="card mb-4">
      <div class="card-header card-header-content-between">
        <h4 class="card-header-title">
          <i class="bi-person-badge text-primary me-2"></i>Vérifications KYC
          @if(($pendingKycCount ?? 0) > 0)
            <span class="badge bg-soft-warning text-warning ms-2">{{ $pendingKycCount }} en attente</span>
          @else
            <span class="badge bg-soft-success text-success ms-2">Tous vérifiés</span>
          @endif
        </h4>
        <a href="{{ route('admin.kyc.index') }}" class="btn btn-white btn-sm"><i class="bi-arrow-right me-1"></i>Voir tout</a>
      </div>
      <div class="card-body p-0">
        @forelse($pendingUsers ?? [] as $user)
          <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-3">
                <span class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
              </div>
              <div>
                <h5 class="mb-0">{{ $user->name }}</h5>
                <span class="text-muted small">{{ $user->email }} · {{ $user->created_at->format('d/m/Y') }}</span>
              </div>
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('admin.kyc.show', $user) }}" class="btn btn-white btn-sm">
                <i class="bi-eye me-1"></i>Voir
              </a>
              <form action="{{ route('admin.investment.kyc.approve', $user) }}" method="POST" class="d-inline js-confirm" data-msg="Approuver le KYC de {{ $user->name }} ?">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                  <i class="bi-check-lg me-1"></i>Approuver
                </button>
              </form>
              <form action="{{ route('admin.investment.kyc.reject', $user) }}" method="POST" class="d-inline js-confirm" data-msg="Rejeter le KYC de {{ $user->name }} ?">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                  <i class="bi-x-lg me-1"></i>Rejeter
                </button>
              </form>
            </div>
          </div>
        @empty
          <div class="text-center py-5">
            <div class="mb-3"><i class="bi-person-check fs-1 text-success"></i></div>
            <h5>Aucune vérification en attente</h5>
            <p class="text-muted mb-0">Tous les membres sont vérifiés.</p>
          </div>
        @endforelse
      </div>
    </div>

    <!-- Recent Approved -->
    @if(isset($recentApproved) && $recentApproved->count() > 0)
    <div class="card">
      <div class="card-header">
        <h4 class="card-header-title"><i class="bi-clock-history text-muted me-2"></i> Dernières validations</h4>
      </div>
      <div class="card-body p-0">
        <ul class="list-group list-group-flush">
          @foreach($recentApproved as $tx)
            <li class="list-group-item d-flex align-items-center justify-content-between p-3">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-xs avatar-soft-{{ $tx->type === 'depot' ? 'success' : 'danger' }} avatar-circle me-3">
                  <span class="avatar-initials"><i class="bi-arrow-{{ $tx->type === 'depot' ? 'down' : 'up' }}-short"></i></span>
                </div>
                <div>
                  <span class="fw-bold">{{ $tx->user->name ?? 'N/A' }}</span>
                  <span class="text-muted small ms-1">{{ $tx->type === 'depot' ? 'Dépôt' : 'Retrait' }} — {{ $tx->updated_at->format('d/m/Y H:i') }}</span>
                </div>
              </div>
              <span class="fw-bold {{ $tx->type === 'depot' ? 'text-success' : 'text-danger' }}">{{ $tx->type === 'depot' ? '+' : '-' }}{{ number_format((float)$tx->montant, 2, ',', ' ') }} $</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif

  </div>
</div>

</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.js-confirm').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        if (!confirm(this.dataset.msg || 'Confirmer cette action ?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
