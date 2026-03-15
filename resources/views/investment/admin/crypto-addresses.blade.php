@extends('layouts.profil')

@section('content')

<div class="content container-fluid">

<!-- Page Header -->
<div class="page-header">
  <div class="row align-items-center">
    <div class="col-sm mb-2 mb-sm-0">
      <h1 class="page-header-title">Gestion des Adresses Crypto</h1>
      <p class="page-header-text">Ajoutez et gérez les adresses USDT/USDC de réception du club sur chaque réseau.</p>
    </div>
  </div>
</div>
<!-- End Page Header -->

<!-- Add new address form -->
<div class="card mb-4">
  <div class="card-header">
    <h4 class="card-header-title"><i class="bi-plus-circle text-primary me-2"></i>Ajouter une adresse</h4>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.crypto.store') }}" method="POST">
        @csrf
        <div class="row align-items-end g-3">
            <div class="col-sm-6 col-md-2">
                <label class="form-label">Coin</label>
                <select name="coin" class="form-select" required>
                    <option value="USDT">USDT</option>
                    <option value="USDC">USDC</option>
                </select>
            </div>
            <div class="col-sm-6 col-md-3">
                <label class="form-label">Réseau</label>
                <select name="network" class="form-select" required>
                    <option value="TRC20 (Tron)">TRC20 (Tron)</option>
                    <option value="ERC20 (Ethereum)">ERC20 (Ethereum)</option>
                    <option value="BEP20 (BSC)">BEP20 (BSC)</option>
                    <option value="SOL (Solana)">SOL (Solana)</option>
                    <option value="Polygon">Polygon</option>
                    <option value="Arbitrum">Arbitrum</option>
                    <option value="Optimism">Optimism</option>
                    <option value="Avalanche C-Chain">Avalanche C-Chain</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Adresse</label>
                <input type="text" name="address" class="form-control" required placeholder="0x... ou T...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Libellé (opt.)</label>
                <input type="text" name="label" class="form-control" placeholder="Ex: Principal">
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary" title="Ajouter">
                    <i class="bi-plus-lg"></i>
                </button>
            </div>
        </div>
    </form>
  </div>
</div>
<!-- End Add new address form -->

<!-- Addresses list -->
@forelse($grouped as $coin => $coinAddresses)
    <div class="card mb-4">
        <div class="card-header card-header-content-between">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-sm avatar-soft-{{ $coin === 'USDT' ? 'success' : 'primary' }} avatar-circle me-3">
                    <span class="avatar-initials" style="font-size: 0.7rem;">{{ $coin }}</span>
                </div>
                <h4 class="card-header-title mb-0">{{ $coin }}</h4>
                <span class="badge bg-soft-secondary text-secondary ms-2">{{ count($coinAddresses) }} adresse(s)</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                <thead class="thead-light">
                    <tr>
                        <th>Réseau</th>
                        <th>Adresse</th>
                        <th>Libellé</th>
                        <th>Statut</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coinAddresses as $addr)
                        <tr class="{{ !$addr['is_active'] ? 'opacity-50' : '' }}">
                            <td>
                                <span class="fw-bold">{{ $addr['network'] }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <code class="text-dark bg-light rounded px-2 py-1 me-2">{{ $addr['address'] }}</code>
                                    <button type="button" class="btn btn-white btn-xs js-clipboard" data-hs-clipboard-options='{
                                        "content": "{{ $addr['address'] }}",
                                        "successText": "Copié!"
                                      }' title="Copier">
                                        <i class="bi-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-muted">{{ $addr['label'] ?? '—' }}</td>
                            <td>
                                @if($addr['is_active'])
                                    <span class="legend-indicator bg-success"></span>Active
                                @else
                                    <span class="legend-indicator bg-danger"></span>Inactive
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.crypto.toggle', $addr['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-white btn-sm {{ $addr['is_active'] ? 'text-warning' : 'text-success' }}" title="{{ $addr['is_active'] ? 'Désactiver' : 'Activer' }}">
                                        <i class="bi-{{ $addr['is_active'] ? 'pause-fill' : 'play-fill' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.crypto.destroy', $addr['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette adresse ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger" title="Supprimer">
                                        <i class="bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="text-center py-5">
        <div class="mb-3"><i class="bi-wallet2 fs-1 text-muted"></i></div>
        <h5>Aucune adresse crypto configurée</h5>
        <p class="text-muted">Ajoutez vos premières adresses USDT/USDC ci-dessus pour que les membres puissent déposer.</p>
    </div>
@endforelse

<!-- Info card -->
<div class="alert alert-soft-info mb-4">
    <div class="d-flex">
        <i class="bi-info-circle-fill fs-2 me-3"></i>
        <div>
            <p class="mb-1"><strong>Fonctionnement :</strong> Les adresses actives sont automatiquement affichées aux membres dans le formulaire de dépôt. Lors d'un dépôt, le membre sélectionne le réseau et voit l'adresse correspondante. Le dépôt est soumis en attente de validation admin.</p>
            <p class="mb-0"><strong>Réseaux recommandés :</strong> TRC20 (frais faibles), BEP20 (rapide), ERC20 (plus cher mais standard).</p>
        </div>
    </div>
</div>

</div>

@endsection
