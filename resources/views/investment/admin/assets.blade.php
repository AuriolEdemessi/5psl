@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <h1 class="page-header-title">Gestion des Actifs</h1>
      <p class="page-header-text">Suivez et mettez à jour les performances de chaque actif du club.</p>
    </div>
    <div class="col-sm-auto">
      <span class="badge bg-soft-info text-info fs-6 p-2">
        <i class="bi-graph-up me-1"></i> NAV : {{ number_format((float)$currentNav, 4) }} $
      </span>
    </div>
  </div>
</div>
<!-- End Page Header -->

<!-- KPI Row -->
<div class="row mb-4">
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Total Actifs</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ $assets->count() }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">AUM Total</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ number_format((float)$stats->total_aum, 2) }} $</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Parts Émises</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ number_format((float)$stats->total_shares, 4) }}</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Opportunités Convertibles</span>
                <span class="d-block fs-3 text-primary fw-bold">{{ $convertibleOpportunities->count() }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Convertible Opportunities Section -->
@if($convertibleOpportunities->isNotEmpty())
<div class="card mb-4">
    <div class="card-header">
        <h4 class="card-header-title">
            <i class="bi-lightning-charge text-warning me-2"></i>Opportunités Approuvées — Prêtes à Convertir
        </h4>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($convertibleOpportunities as $opp)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card border shadow-none h-100">
                    <div class="card-body">
                        <span class="badge bg-soft-primary text-primary mb-2 text-uppercase">{{ $opp->type }}</span>
                        <h5 class="card-title">{{ $opp->titre }}</h5>
                        <p class="card-text text-muted small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $opp->description }}
                        </p>
                        <div class="text-muted small mb-3">
                            Montant estimé : <strong>{{ $opp->montant_estime ? number_format((float)$opp->montant_estime, 2) . ' $' : 'N/A' }}</strong>
                        </div>
                        <button type="button" class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#convertModal{{ $opp->id }}">
                            <i class="bi-arrow-right-circle me-1"></i> Convertir en Actif
                        </button>
                    </div>
                </div>
            </div>

            <!-- Convert Modal -->
            <div class="modal fade" id="convertModal{{ $opp->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.opportunities.convert', $opp) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Convertir « {{ $opp->titre }} » en Actif</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Valeur initiale de l'investissement ($)</label>
                                    <input type="number" step="0.01" min="0.01" name="valeur_initiale" class="form-control"
                                        value="{{ (float)$opp->montant_estime > 0 ? $opp->montant_estime : '' }}" required>
                                    <div class="form-text">Montant réellement investi par le club dans cet actif.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Catégorie d'allocation</label>
                                    <select name="categorie" class="form-select" required>
                                        <option value="securite">Sécurité (50%) — Bons du Trésor, Obligations</option>
                                        <option value="croissance">Croissance (30%) — Actions, ETF</option>
                                        <option value="opportunite" selected>Opportunité (20%) — Crypto, Startups</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi-check-lg me-1"></i> Confirmer la Conversion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Assets List -->
<div class="card">
    <div class="card-header">
        <h4 class="card-header-title">
            <i class="bi-briefcase me-2"></i>Actifs du Club
        </h4>
    </div>

    @if($assets->isEmpty())
    <div class="card-body text-center py-5">
        <span class="icon icon-lg icon-soft-primary icon-circle mb-3">
            <i class="bi-briefcase"></i>
        </span>
        <h5>Aucun actif</h5>
        <p class="text-muted">Convertissez une opportunité approuvée pour créer votre premier actif.</p>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th>Actif</th>
                    <th>Type</th>
                    <th>Catégorie</th>
                    <th class="text-end">Valeur Initiale</th>
                    <th class="text-end">Valeur Actuelle</th>
                    <th class="text-end">ROI</th>
                    <th class="text-end">Dernière MAJ</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assets as $asset)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-2">
                                <span class="avatar-initials">
                                    @if($asset->type === 'crypto') <i class="bi-currency-bitcoin"></i>
                                    @elseif($asset->type === 'action') <i class="bi-graph-up-arrow"></i>
                                    @elseif($asset->type === 'immobilier') <i class="bi-building"></i>
                                    @elseif($asset->type === 'obligation') <i class="bi-shield-check"></i>
                                    @else <i class="bi-box"></i>
                                    @endif
                                </span>
                            </div>
                            <div>
                                <span class="d-block fw-semibold text-dark">{{ $asset->nom }}</span>
                                @if($asset->opportunity)
                                <small class="text-muted">depuis opportunité</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-soft-info text-info text-uppercase">{{ $asset->type }}</span></td>
                    <td>
                        @if($asset->categorie === 'securite')
                            <span class="badge bg-soft-success text-success">Sécurité</span>
                        @elseif($asset->categorie === 'croissance')
                            <span class="badge bg-soft-warning text-warning">Croissance</span>
                        @else
                            <span class="badge bg-soft-danger text-danger">Opportunité</span>
                        @endif
                    </td>
                    <td class="text-end">{{ number_format((float)$asset->valeur_initiale, 2) }} $</td>
                    <td class="text-end fw-bold">{{ number_format((float)$asset->valeur_actuelle, 2) }} $</td>
                    <td class="text-end">
                        @php $roi = $asset->roiPct(); @endphp
                        <span class="{{ $roi >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ $roi >= 0 ? '+' : '' }}{{ number_format($roi, 2) }}%
                        </span>
                    </td>
                    <td class="text-end">
                        @if($asset->latestPerformance)
                            <small class="text-muted">{{ $asset->latestPerformance->date->format('d/m/Y') }}</small>
                        @else
                            <small class="text-muted">—</small>
                        @endif
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#perfModal{{ $asset->id }}">
                            <i class="bi-plus-circle me-1"></i> Performance
                        </button>
                        <a href="{{ route('admin.assets.show', $asset) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi-eye"></i>
                        </a>
                    </td>
                </tr>

                <!-- Performance Modal -->
                <div class="modal fade" id="perfModal{{ $asset->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.assets.performance', $asset) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Enregistrer Performance — {{ $asset->nom }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-soft-info mb-3">
                                        <i class="bi-info-circle me-1"></i>
                                        Valeur actuelle : <strong>{{ number_format((float)$asset->valeur_actuelle, 2) }} $</strong>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label class="form-label">Date</label>
                                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Période</label>
                                            <select name="type_periode" class="form-select" required>
                                                <option value="daily">Journalier</option>
                                                <option value="weekly">Hebdomadaire</option>
                                                <option value="monthly">Mensuel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mode de saisie</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="input_type" id="pctMode{{ $asset->id }}" value="percentage" checked>
                                            <label class="btn btn-outline-primary" for="pctMode{{ $asset->id }}">% Variation</label>
                                            <input type="radio" class="btn-check" name="input_type" id="absMode{{ $asset->id }}" value="absolute">
                                            <label class="btn btn-outline-primary" for="absMode{{ $asset->id }}">Valeur Absolue</label>
                                        </div>
                                    </div>

                                    <div class="mb-3" id="pctField{{ $asset->id }}">
                                        <label class="form-label">Variation en %</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="variation_pct" class="form-control" placeholder="ex: 5.25 ou -2.50">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <div class="form-text">Positif = gain, négatif = perte</div>
                                    </div>

                                    <div class="mb-3 d-none" id="absField{{ $asset->id }}">
                                        <label class="form-label">Nouvelle valeur ($)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" min="0" name="valeur_apres" class="form-control" placeholder="ex: 1250.00">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Notes (optionnel)</label>
                                        <textarea name="notes" class="form-control" rows="2" placeholder="ex: Hausse suite à annonce partenariat..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi-save me-1"></i> Enregistrer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle between percentage and absolute input modes
    document.querySelectorAll('input[name="input_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var assetId = this.id.replace('pctMode', '').replace('absMode', '');
            var pctField = document.getElementById('pctField' + assetId);
            var absField = document.getElementById('absField' + assetId);
            if (this.value === 'percentage') {
                pctField.classList.remove('d-none');
                absField.classList.add('d-none');
            } else {
                pctField.classList.add('d-none');
                absField.classList.remove('d-none');
            }
        });
    });
});
</script>
@endpush

@endsection
