@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-no-gutter">
          <li class="breadcrumb-item"><a href="{{ route('admin.assets.index') }}">Actifs</a></li>
          <li class="breadcrumb-item active">{{ $asset->nom }}</li>
        </ol>
      </nav>
      <h1 class="page-header-title">
        {{ $asset->nom }}
        @if($asset->is_active)
            <span class="badge bg-soft-success text-success ms-2 fs-6">Actif</span>
        @else
            <span class="badge bg-soft-danger text-danger ms-2 fs-6">Inactif</span>
        @endif
      </h1>
      @if($asset->description)
      <p class="page-header-text">{{ $asset->description }}</p>
      @endif
    </div>
    <div class="col-sm-auto">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#perfModalShow">
        <i class="bi-plus-circle me-1"></i> Nouvelle Performance
      </button>
      <a href="{{ route('admin.assets.index') }}" class="btn btn-white ms-2">
        <i class="bi-arrow-left me-1"></i> Retour
      </a>
    </div>
  </div>
</div>

<!-- KPI Cards -->
<div class="row mb-4">
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Valeur Initiale</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ number_format((float)$asset->valeur_initiale, 2) }} $</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Valeur Actuelle</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ number_format((float)$asset->valeur_actuelle, 2) }} $</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">ROI</span>
                @php $roi = $asset->roiPct(); @endphp
                <span class="d-block fs-3 fw-bold {{ $roi >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $roi >= 0 ? '+' : '' }}{{ number_format($roi, 2) }}%
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
        <div class="card card-sm">
            <div class="card-body">
                <span class="d-block fs-6 text-muted mb-1">Entrées de Performance</span>
                <span class="d-block fs-3 text-dark fw-bold">{{ $asset->performances->count() }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="row mb-4">
    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-header-title"><i class="bi-info-circle me-2"></i>Informations</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Type</span>
                        <span class="badge bg-soft-info text-info text-uppercase">{{ $asset->type }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Catégorie</span>
                        @if($asset->categorie === 'securite')
                            <span class="badge bg-soft-success text-success">Sécurité (50%)</span>
                        @elseif($asset->categorie === 'croissance')
                            <span class="badge bg-soft-warning text-warning">Croissance (30%)</span>
                        @else
                            <span class="badge bg-soft-danger text-danger">Opportunité (20%)</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Créé le</span>
                        <span>{{ $asset->created_at?->format('d/m/Y') ?? '—' }}</span>
                    </li>
                    @if($asset->opportunity)
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">Opportunité source</span>
                        <span>{{ $asset->opportunity->titre }}</span>
                    </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted">P&L ($)</span>
                        @php $pnl = (float)$asset->valeur_actuelle - (float)$asset->valeur_initiale; @endphp
                        <span class="fw-bold {{ $pnl >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $pnl >= 0 ? '+' : '' }}{{ number_format($pnl, 2) }} $
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="card-header-title"><i class="bi-graph-up me-2"></i>Historique des Performances</h4>
            </div>
            @if($asset->performances->isEmpty())
            <div class="card-body text-center py-5">
                <span class="icon icon-lg icon-soft-primary icon-circle mb-3">
                    <i class="bi-bar-chart-line"></i>
                </span>
                <h5>Aucune donnée de performance</h5>
                <p class="text-muted">Cliquez sur « Nouvelle Performance » pour ajouter la première entrée.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Période</th>
                            <th class="text-end">Avant</th>
                            <th class="text-end">Après</th>
                            <th class="text-end">Variation</th>
                            <th>Notes</th>
                            <th>Par</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->performances as $perf)
                        <tr>
                            <td>{{ $perf->date->format('d/m/Y') }}</td>
                            <td>
                                @if($perf->type_periode === 'daily')
                                    <span class="badge bg-soft-info text-info">Jour</span>
                                @elseif($perf->type_periode === 'weekly')
                                    <span class="badge bg-soft-primary text-primary">Semaine</span>
                                @else
                                    <span class="badge bg-soft-dark text-dark">Mois</span>
                                @endif
                            </td>
                            <td class="text-end">{{ number_format((float)$perf->valeur_avant, 2) }} $</td>
                            <td class="text-end fw-bold">{{ number_format((float)$perf->valeur_apres, 2) }} $</td>
                            <td class="text-end">
                                <span class="{{ (float)$perf->variation_pct >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ (float)$perf->variation_pct >= 0 ? '+' : '' }}{{ number_format((float)$perf->variation_pct, 2) }}%
                                </span>
                                <br>
                                <small class="text-muted">{{ (float)$perf->variation_absolue >= 0 ? '+' : '' }}{{ number_format((float)$perf->variation_absolue, 2) }} $</small>
                            </td>
                            <td>
                                @if($perf->notes)
                                    <span class="text-muted small" title="{{ $perf->notes }}" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;max-width:200px;">
                                        {{ $perf->notes }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($perf->recorder)
                                    <small class="text-muted">{{ $perf->recorder->name }}</small>
                                @else
                                    <small class="text-muted">—</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

</div>

<!-- Performance Modal -->
<div class="modal fade" id="perfModalShow" tabindex="-1">
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
                            <input type="radio" class="btn-check" name="input_type" id="pctModeShow" value="percentage" checked>
                            <label class="btn btn-outline-primary" for="pctModeShow">% Variation</label>
                            <input type="radio" class="btn-check" name="input_type" id="absModeShow" value="absolute">
                            <label class="btn btn-outline-primary" for="absModeShow">Valeur Absolue</label>
                        </div>
                    </div>

                    <div class="mb-3" id="pctFieldShow">
                        <label class="form-label">Variation en %</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="variation_pct" class="form-control" placeholder="ex: 5.25 ou -2.50">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">Positif = gain, négatif = perte</div>
                    </div>

                    <div class="mb-3 d-none" id="absFieldShow">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="input_type"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var pctField = document.getElementById('pctFieldShow');
            var absField = document.getElementById('absFieldShow');
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
