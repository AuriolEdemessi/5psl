@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Tableau de bord Admin</h1>
        <p class="page-header-text">Vue d'ensemble du club d'investissement 5PSL</p>
      </div>
      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
          <i class="bi-person-plus-fill me-1"></i> Nouveau membre
        </a>
      </div>
    </div>
  </div>
  <!-- End Page Header -->

  <!-- Alert badges -->
  @if($pendingTransactions > 0 || $pendingKycCount > 0 || $openTickets > 0)
  <div class="alert alert-soft-warning mb-4" role="alert">
    <div class="d-flex align-items-center flex-wrap">
      <i class="bi-exclamation-triangle-fill me-2"></i>
      <strong>Actions requises :</strong>
      @if($pendingTransactions > 0)
        <a href="{{ route('investment.admin.index') }}" class="ms-3 badge bg-danger">{{ $pendingTransactions }} transaction(s) en attente</a>
      @endif
      @if($pendingKycCount > 0)
        <a href="{{ route('admin.kyc.index') }}" class="ms-3 badge bg-warning text-dark">{{ $pendingKycCount }} KYC en attente</a>
      @endif
      @if($openTickets > 0)
        <a href="{{ route('admin.support.index') }}" class="ms-3 badge bg-info">{{ $openTickets }} ticket(s) ouvert(s)</a>
      @endif
    </div>
  </div>
  @endif

  <!-- Stats Cards -->
  <div class="row">
    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <a class="card card-hover-shadow h-100" href="{{ route('admin.users.index') }}">
        <div class="card-body">
          <h6 class="card-subtitle">Membres</h6>
          <div class="row align-items-center gx-2 mb-1">
            <div class="col">
              <h2 class="card-title text-inherit">{{ $totalMembers }}</h2>
            </div>
            <div class="col-auto">
              <span class="icon icon-sm icon-soft-primary icon-circle">
                <i class="bi-people"></i>
              </span>
            </div>
          </div>
          <span class="badge bg-soft-success text-success">
            <i class="bi-person-check"></i> {{ $verifiedKycCount }} vérifiés
          </span>
        </div>
      </a>
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <a class="card card-hover-shadow h-100" href="{{ route('investment.admin.index') }}">
        <div class="card-body">
          <h6 class="card-subtitle">NAV actuelle</h6>
          <div class="row align-items-center gx-2 mb-1">
            <div class="col">
              <h2 class="card-title text-inherit">${{ number_format((float)$stats->current_nav, 2) }}</h2>
            </div>
            <div class="col-auto">
              <span class="icon icon-sm icon-soft-success icon-circle">
                <i class="bi-graph-up-arrow"></i>
              </span>
            </div>
          </div>
          <span class="text-body fs-6">{{ number_format((float)$stats->total_shares, 2) }} parts en circulation</span>
        </div>
      </a>
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle">Total Dépôts</h6>
          <div class="row align-items-center gx-2 mb-1">
            <div class="col">
              <h2 class="card-title">${{ number_format($totalDeposits, 2) }}</h2>
            </div>
            <div class="col-auto">
              <span class="icon icon-sm icon-soft-info icon-circle">
                <i class="bi-arrow-down-circle"></i>
              </span>
            </div>
          </div>
          <span class="text-body fs-6">AUM: ${{ number_format((float)$stats->total_aum, 2) }}</span>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle">Total Retraits</h6>
          <div class="row align-items-center gx-2 mb-1">
            <div class="col">
              <h2 class="card-title">${{ number_format($totalWithdrawals, 2) }}</h2>
            </div>
            <div class="col-auto">
              <span class="icon icon-sm icon-soft-danger icon-circle">
                <i class="bi-arrow-up-circle"></i>
              </span>
            </div>
          </div>
          <span class="badge bg-soft-warning text-warning">{{ $pendingTransactions }} en attente</span>
        </div>
      </div>
    </div>
  </div>
  <!-- End Stats Cards -->

  <!-- Row: Tier Breakdown + Quick Actions + Recent Members -->
  <div class="row">
    <div class="col-lg-4 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-header">
          <h4 class="card-header-title">Répartition des Tiers</h4>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><i class="bi-star text-secondary me-2"></i> STARTER</span>
              <span class="badge bg-secondary rounded-pill">{{ $tierBreakdown['STARTER'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><i class="bi-star-half text-primary me-2"></i> PRO</span>
              <span class="badge bg-primary rounded-pill">{{ $tierBreakdown['PRO'] }}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><i class="bi-star-fill text-warning me-2"></i> ELITE</span>
              <span class="badge bg-warning rounded-pill">{{ $tierBreakdown['ELITE'] }}</span>
            </li>
          </ul>
          <div class="mt-3 text-center">
            <small class="text-muted">{{ $totalMembers }} membres au total</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-header">
          <h4 class="card-header-title">Accès rapides</h4>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('investment.admin.index') }}" class="btn btn-outline-primary btn-sm">
              <i class="bi-speedometer2 me-1"></i> Gestion Club
            </a>
            <a href="{{ route('admin.kyc.index') }}" class="btn btn-outline-warning btn-sm">
              <i class="bi-person-check me-1"></i> Vérifications KYC
              @if($pendingKycCount > 0) <span class="badge bg-warning text-dark ms-1">{{ $pendingKycCount }}</span> @endif
            </a>
            <a href="{{ route('admin.wallets.index') }}" class="btn btn-outline-dark btn-sm">
              <i class="bi-wallet2 me-1"></i> Portefeuilles Centraux
            </a>
            <a href="{{ route('opportunities.create') }}" class="btn btn-outline-success btn-sm">
              <i class="bi-lightbulb me-1"></i> Nouvelle Opportunité
            </a>
            <a href="{{ route('admin.support.index') }}" class="btn btn-outline-info btn-sm">
              <i class="bi-headset me-1"></i> Support
              @if($openTickets > 0) <span class="badge bg-info ms-1">{{ $openTickets }}</span> @endif
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-header card-header-content-between">
          <h4 class="card-header-title">Nouveaux membres</h4>
          <a class="btn btn-ghost-secondary btn-sm" href="{{ route('admin.users.index') }}">Voir tout</a>
        </div>
        <div class="card-body card-body-height" style="max-height: 18rem;">
          <ul class="list-group list-group-flush">
            @forelse($recentMembers as $member)
            <li class="list-group-item">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-3">
                  <span class="avatar-initials">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-0 fs-6">{{ $member->name }}</h5>
                  <span class="d-block fs-6 text-muted">{{ $member->email }}</span>
                </div>
                <div>
                  @if($member->kyc_status === 'verified')
                    <span class="badge bg-soft-success text-success">Vérifié</span>
                  @elseif($member->kyc_status === 'pending')
                    <span class="badge bg-soft-warning text-warning">En attente</span>
                  @elseif($member->kyc_status === 'not_started')
                    <span class="badge bg-soft-secondary text-secondary">Non soumis</span>
                  @else
                    <span class="badge bg-soft-danger text-danger">Rejeté</span>
                  @endif
                </div>
              </div>
            </li>
            @empty
            <li class="list-group-item text-center text-muted">Aucun membre pour l'instant</li>
            @endforelse
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- End Row -->

  <!-- Recent Transactions -->
  <div class="card mb-3 mb-lg-5">
    <div class="card-header card-header-content-between">
      <h4 class="card-header-title">Dernières transactions</h4>
      <a class="btn btn-ghost-secondary btn-sm" href="{{ route('investment.admin.index') }}">Voir tout</a>
    </div>
    <div class="table-responsive">
      <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th>Membre</th>
            <th>Type</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentTransactions as $tx)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-2">
                  <span class="avatar-initials">{{ strtoupper(substr($tx->user->name ?? '?', 0, 1)) }}</span>
                </div>
                <span>{{ $tx->user->name ?? 'N/A' }}</span>
              </div>
            </td>
            <td>
              @if($tx->type === 'depot')
                <span class="badge bg-soft-success text-success">Dépôt</span>
              @else
                <span class="badge bg-soft-info text-info">Retrait</span>
              @endif
            </td>
            <td>${{ number_format((float)$tx->montant, 2) }}</td>
            <td>
              @if($tx->statut === 'en_attente')
                <span class="badge bg-soft-warning text-warning">En attente</span>
              @elseif(in_array($tx->statut, ['approuve', 'valide']))
                <span class="badge bg-soft-success text-success">Validée</span>
              @else
                <span class="badge bg-soft-danger text-danger">Rejetée</span>
              @endif
            </td>
            <td>{{ $tx->created_at->format('d/m/Y H:i') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Aucune transaction pour l'instant</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <!-- End Recent Transactions -->

</div>

@endsection
