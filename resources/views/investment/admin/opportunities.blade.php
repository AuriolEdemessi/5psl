@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <h1 class="page-header-title">Opportunités d'Investissement</h1>
      <p class="page-header-text">Gérez les opportunités d'investissement et suivez les votes des membres.</p>
    </div>
    <div class="col-sm-auto">
      <a class="btn btn-primary" href="{{ route('opportunities.create') }}">
        <i class="bi-plus me-1"></i> Nouvelle Opportunité
      </a>
    </div>
  </div>
</div>
<!-- End Page Header -->


<div class="row">
    @forelse($opportunities as $opportunity)
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-soft-primary text-primary mb-2 text-uppercase">{{ $opportunity->type }}</span>
                            <h4 class="card-title"><a href="{{ route('opportunities.show', $opportunity) }}" class="text-dark">{{ $opportunity->titre }}</a></h4>
                        </div>
                        @if($opportunity->statut === 'ouverte')
                            <span class="badge bg-soft-success text-success"><i class="bi-unlock me-1"></i>Ouvert</span>
                        @elseif($opportunity->statut === 'approuvee')
                            <span class="badge bg-soft-success text-success"><i class="bi-check-circle me-1"></i>Approuvé</span>
                        @else
                            <span class="badge bg-soft-danger text-danger"><i class="bi-x-circle me-1"></i>Rejeté</span>
                        @endif
                    </div>

                    <p class="card-text text-muted mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $opportunity->description }}
                    </p>

                    <div class="bg-light rounded p-3 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small fw-semibold">Montant Estimé :</span>
                            <span class="fw-bold text-dark">
                                {{ $opportunity->montant_estime ? number_format((float)$opportunity->montant_estime, 2, ',', ' ') . ' FCFA' : 'Non défini' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small fw-semibold">Date limite :</span>
                            <span class="fw-bold text-danger">
                                {{ $opportunity->date_limite_vote ? \Carbon\Carbon::parse($opportunity->date_limite_vote)->format('d M, Y') : 'Non définie' }}
                            </span>
                        </div>
                    </div>

                    @php
                        $totalVotes = $opportunity->approvals_count + $opportunity->rejections_count;
                        $approvalPercentage = $totalVotes > 0 ? ($opportunity->approvals_count / $totalVotes) * 100 : 0;
                        $rejectionPercentage = $totalVotes > 0 ? ($opportunity->rejections_count / $totalVotes) * 100 : 0;
                    @endphp

                    <div class="mb-4">
                        <div class="d-flex justify-content-between small fw-bold mb-1">
                            <span class="text-success">Pour ({{ number_format($approvalPercentage, 1) }}%)</span>
                            <span class="text-danger">Contre ({{ number_format($rejectionPercentage, 1) }}%)</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $approvalPercentage }}%" aria-valuenow="{{ $approvalPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $rejectionPercentage }}%" aria-valuenow="{{ $rejectionPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="text-center small text-muted mt-2">
                            {{ $totalVotes }} vote(s) au total
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('opportunities.show', $opportunity) }}" class="btn btn-outline-primary flex-grow-1">
                            Voir les détails & Voter
                        </a>
                        @if($opportunity->statut === 'approuvee' && !$opportunity->isConvertedToAsset())
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-success" title="Convertir en actif">
                            <i class="bi-arrow-right-circle"></i>
                        </a>
                        @elseif($opportunity->isConvertedToAsset())
                        <span class="btn btn-soft-success disabled" title="Déjà converti en actif">
                            <i class="bi-check-circle"></i>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-3">
                    <span class="icon icon-lg icon-soft-primary icon-circle">
                        <i class="bi-lightbulb"></i>
                    </span>
                </div>
                <h5>Aucune opportunité pour le moment</h5>
                <p class="text-muted max-w-sm mx-auto">Vous n'avez pas encore publié d'opportunité d'investissement.</p>
                <a href="{{ route('opportunities.create') }}" class="btn btn-primary mt-3">
                    <i class="bi-plus me-1"></i> Créer une opportunité
                </a>
            </div>
        </div>
    @endforelse
</div>

<div class="card-footer">
    {{ $opportunities->links() }}
</div>

</div>

@endsection
