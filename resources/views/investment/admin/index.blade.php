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
    <div class="col-sm-auto">
      <a class="btn btn-primary" href="{{ route('opportunities.create') }}">
        <i class="bi-plus me-1"></i> Nouvelle Opportunité
      </a>
    </div>
  </div>
</div>
<!-- End Page Header -->

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
<!-- End Stats Banner -->

<!-- Stats -->
<div class="row mb-4">
  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <!-- Card -->
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">KYC en attente</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 {{ ($pendingKycCount ?? 0) > 0 ? 'text-warning' : 'text-success' }}">{{ $pendingKycCount ?? 0 }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-primary icon-circle">
              <i class="bi-person-badge"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>

  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <!-- Card -->
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Transactions en attente</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 {{ ($pendingTransactionsCount ?? 0) > 0 ? 'text-warning' : 'text-success' }}">{{ $pendingTransactionsCount ?? 0 }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-warning icon-circle">
              <i class="bi-hourglass-split"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>

  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <!-- Card -->
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Total Frais perçus</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-dark">{{ number_format($totalFees, 2, ',', ' ') }} <span class="fs-6 text-muted">$</span></span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-success icon-circle">
              <i class="bi-cash-stack"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>

  <div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Commissions HWM</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-dark">{{ number_format($totalCommissions, 2, ',', ' ') }} <span class="fs-6 text-muted">$</span></span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-info icon-circle">
              <i class="bi-percent"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>
</div>
<!-- End Stats -->

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
              <div>
                <span class="badge {{ $tc }} text-white">{{ $tierName }}</span>
              </div>
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
    <!-- End Tier Breakdown -->

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
    <!-- End Portfolio Allocation -->

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
    <!-- End Financial Summary -->

  </div>
  <!-- End Left Column -->

  <!-- Right Column -->
  <div class="col-lg-8">
    
    <!-- KYC Table -->
    <div class="card mb-4">
      <div class="card-header card-header-content-between">
        <h4 class="card-header-title">
          Vérifications KYC
          @if(($pendingKycCount ?? 0) > 0)
            <span class="badge bg-soft-warning text-warning ms-1">{{ $pendingKycCount }}</span>
          @else
            <span class="badge bg-soft-success text-success ms-1">OK</span>
          @endif
        </h4>
      </div>
      
      <div class="table-responsive">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
          <thead class="thead-light">
            <tr>
              <th>Membre</th>
              <th>Email</th>
              <th>Inscrit le</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendingUsers ?? [] as $user)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-3">
                      <span class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                      <span class="d-block h5 text-inherit mb-0">{{ $user->name }}</span>
                      <span class="badge bg-info rounded-pill" style="font-size: 0.6rem;">{{ $user->tier ?? 'STARTER' }}</span>
                    </div>
                  </div>
                </td>
                <td>{{ $user->email }}</td>
                <td><span class="text-muted small">{{ $user->created_at->format('d/m/Y H:i') }}</span></td>
                <td class="text-end">
                  <form action="{{ route('admin.kyc.approve', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-white btn-sm text-success" title="Approuver">
                      <i class="bi-check-lg"></i>
                    </button>
                  </form>
                  <form action="{{ route('admin.kyc.reject', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-white btn-sm text-danger" title="Rejeter">
                      <i class="bi-x-lg"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center py-5">
                  <div class="mb-3"><i class="bi-person-check fs-1 text-muted"></i></div>
                  <h5>Aucune vérification en attente</h5>
                  <p class="text-muted">Tous les membres sont vérifiés.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <!-- End KYC Table -->

    <!-- Transactions Table -->
    <div class="card mb-4">
      <div class="card-header card-header-content-between">
        <h4 class="card-header-title">
          Transactions en attente
          @if(($pendingTransactionsCount ?? 0) > 0)
            <span class="badge bg-soft-warning text-warning ms-1">{{ $pendingTransactionsCount }}</span>
          @else
            <span class="badge bg-soft-success text-success ms-1">OK</span>
          @endif
        </h4>
      </div>
      
      <div class="table-responsive">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
          <thead class="thead-light">
            <tr>
              <th>Membre</th>
              <th>Type</th>
              <th>Montant</th>
              <th>Frais</th>
              <th>Net</th>
              <th>Date</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendingTransactions ?? [] as $transaction)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-2">
                      <span class="avatar-initials">{{ strtoupper(substr($transaction->user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                      <span class="d-block fw-bold">{{ $transaction->user->name }}</span>
                      <span class="badge bg-info rounded-pill" style="font-size: 0.6rem;">{{ $transaction->user->tier ?? 'STARTER' }}</span>
                    </div>
                  </div>
                </td>
                <td>
                  @if($transaction->type === 'depot')
                    <span class="badge bg-soft-success text-success"><i class="bi-arrow-down-short me-1"></i>Dépôt</span>
                  @else
                    <span class="badge bg-soft-danger text-danger"><i class="bi-arrow-up-short me-1"></i>Retrait</span>
                  @endif
                </td>
                <td class="fw-bold">{{ number_format((float)$transaction->montant, 2, ',', ' ') }} $</td>
                <td class="text-warning small">{{ number_format((float)($transaction->frais_entree ?? 0), 2) }} $</td>
                <td class="text-success fw-bold">{{ number_format((float)($transaction->montant_net ?? $transaction->montant), 2) }} $</td>
                <td class="text-muted small">{{ $transaction->created_at->format('d/m H:i') }}</td>
                <td class="text-end">
                  <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-white btn-sm text-success" title="Approuver">
                      <i class="bi-check-lg"></i>
                    </button>
                  </form>
                  <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-white btn-sm text-danger" title="Rejeter">
                      <i class="bi-x-lg"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-5">
                  <div class="mb-3"><i class="bi-check2-all fs-1 text-muted"></i></div>
                  <h5>Aucune transaction en attente</h5>
                  <p class="text-muted">Toutes les transactions ont été traitées.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    <!-- End Transactions Table -->

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
                  <span class="text-muted small ms-1">— {{ $tx->updated_at->format('d/m H:i') }}</span>
                </div>
              </div>
              <span class="fw-bold">{{ number_format((float)$tx->montant, 2, ',', ' ') }} $</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif
    <!-- End Recent Approved -->

  </div>
  <!-- End Right Column -->
</div>

</div>

@endsection
