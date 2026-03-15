@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <h1 class="page-header-title">Gestion du Support</h1>
      <p class="page-header-text">Répondez aux demandes d'assistance des membres du club.</p>
    </div>
  </div>
</div>
<!-- End Page Header -->

<!-- Stats -->
<div class="row mb-4">
  <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
    <!-- Card -->
    <div class="card h-100">
      <div class="card-body">
        <h6 class="card-subtitle mb-2">Ouverts</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-danger">{{ $stats['open'] }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-danger icon-circle">
              <i class="bi-envelope-open"></i>
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
        <h6 class="card-subtitle mb-2">En cours</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-warning">{{ $stats['in_progress'] }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-warning icon-circle">
              <i class="bi-arrow-repeat"></i>
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
        <h6 class="card-subtitle mb-2">Résolus</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-success">{{ $stats['resolved'] }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-success icon-circle">
              <i class="bi-check-circle"></i>
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
        <h6 class="card-subtitle mb-2">Total</h6>
        <div class="row align-items-center gx-2">
          <div class="col">
            <span class="js-counter display-4 text-dark">{{ $stats['total'] }}</span>
          </div>
          <div class="col-auto">
            <span class="icon icon-sm icon-soft-primary icon-circle">
              <i class="bi-headset"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>
</div>
<!-- End Stats -->

<!-- Filters -->
<div class="card mb-4">
  <div class="card-header">
    <form method="GET" action="{{ route('admin.support.index') }}">
      <div class="row align-items-end gx-2">
        <div class="col-sm-3 mb-2 mb-sm-0">
          <label class="form-label" for="statusFilter">Statut</label>
          <select name="status" id="statusFilter" class="form-select">
            <option value="">Tous statuts</option>
            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Ouvert</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Résolu</option>
            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Fermé</option>
          </select>
        </div>
        <div class="col-sm-3 mb-2 mb-sm-0">
          <label class="form-label" for="categoryFilter">Catégorie</label>
          <select name="category" id="categoryFilter" class="form-select">
            <option value="">Toutes catégories</option>
            <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>Général</option>
            <option value="depot" {{ request('category') === 'depot' ? 'selected' : '' }}>Dépôt</option>
            <option value="retrait" {{ request('category') === 'retrait' ? 'selected' : '' }}>Retrait</option>
            <option value="investissement" {{ request('category') === 'investissement' ? 'selected' : '' }}>Investissement</option>
            <option value="kyc" {{ request('category') === 'kyc' ? 'selected' : '' }}>KYC</option>
            <option value="technique" {{ request('category') === 'technique' ? 'selected' : '' }}>Technique</option>
          </select>
        </div>
        <div class="col-sm-3 mb-2 mb-sm-0">
          <label class="form-label" for="priorityFilter">Priorité</label>
          <select name="priority" id="priorityFilter" class="form-select">
            <option value="">Toutes priorités</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Haute</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Basse</option>
          </select>
        </div>
        <div class="col-sm-auto">
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="bi-funnel me-1"></i> Filtrer</button>
            <a href="{{ route('admin.support.index') }}" class="btn btn-white">Réinitialiser</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End Filters -->

<!-- Tickets table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Membre</th>
                    <th>Sujet</th>
                    <th>Catégorie</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Assigné</th>
                    <th>Dernier msg</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    @php
                        $statusColors = ['open' => 'danger', 'in_progress' => 'warning', 'resolved' => 'success', 'closed' => 'secondary'];
                        $statusLabels = ['open' => 'Ouvert', 'in_progress' => 'En cours', 'resolved' => 'Résolu', 'closed' => 'Fermé'];
                        $priorityColors = ['high' => 'text-danger', 'medium' => 'text-warning', 'low' => 'text-secondary'];
                        $sc = $statusColors[$ticket->status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td class="text-muted fw-bold">#{{ $ticket->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-2">
                                    <span class="avatar-initials">{{ strtoupper(substr($ticket->user->name, 0, 1)) }}</span>
                                </div>
                                <span class="fw-bold text-dark">{{ $ticket->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('support.show', $ticket) }}" class="text-dark fw-bold">
                                {{ Str::limit($ticket->subject, 40) }}
                            </a>
                        </td>
                        <td><span class="text-capitalize">{{ $ticket->category }}</span></td>
                        <td>
                            <span class="fw-bold {{ $priorityColors[$ticket->priority] ?? 'text-secondary' }}">
                                <i class="bi-circle-fill small me-1"></i> {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="legend-indicator bg-{{ $sc }}"></span>{{ $statusLabels[$ticket->status] ?? $ticket->status }}
                        </td>
                        <td class="text-muted">{{ $ticket->assignedAdmin->name ?? '—' }}</td>
                        <td class="text-muted small">{{ $ticket->updated_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('support.show', $ticket) }}" class="btn btn-white btn-sm text-primary" title="Voir">
                                    <i class="bi-chat-dots"></i>
                                </a>
                                @if(!$ticket->assigned_to)
                                    <form action="{{ route('admin.support.assign', $ticket) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-white btn-sm text-success" title="S'assigner">
                                            <i class="bi-person-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <div class="mb-3"><i class="bi-headset fs-1 text-muted"></i></div>
                            <h5>Aucun ticket</h5>
                            <p class="text-muted">Tous les tickets ont été traités.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tickets->hasPages())
        <div class="card-footer">
            {{ $tickets->withQueryString()->links() }}
        </div>
    @endif
</div>

</div>

@endsection
