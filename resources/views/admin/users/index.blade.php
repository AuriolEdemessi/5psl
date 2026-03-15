@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Gestion des Utilisateurs</h1>
        <p class="page-header-text">Gérez les membres et administrateurs de la plateforme.</p>
      </div>
      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
          <i class="bi-person-plus-fill me-1"></i> Nouvel utilisateur
        </a>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Tier</th>
            <th>KYC</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar avatar-sm avatar-soft-primary avatar-circle me-2">
                  <span class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <span class="fw-bold">{{ $user->name }}</span>
              </div>
            </td>
            <td>{{ $user->email }}</td>
            <td>
              @if($user->role === 'admin' || $user->role === 'superadmin')
                <span class="badge bg-soft-success text-success">{{ strtoupper($user->role) }}</span>
              @else
                <span class="badge bg-soft-secondary text-secondary">MEMBER</span>
              @endif
            </td>
            <td>
              @if($user->tier === 'ELITE')
                <span class="badge bg-soft-warning text-warning"><i class="bi-star-fill me-1"></i>ELITE</span>
              @elseif($user->tier === 'PRO')
                <span class="badge bg-soft-primary text-primary">PRO</span>
              @else
                <span class="badge bg-soft-secondary text-secondary">STARTER</span>
              @endif
            </td>
            <td>
              @if($user->kyc_status === 'verified')
                <span class="legend-indicator bg-success"></span>Vérifié
              @elseif($user->kyc_status === 'pending')
                <span class="legend-indicator bg-warning"></span>En attente
              @elseif($user->kyc_status === 'not_started')
                <span class="legend-indicator bg-secondary"></span>Non soumis
              @else
                <span class="legend-indicator bg-danger"></span>Rejeté
              @endif
            </td>
            <td>
              <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-white btn-sm" title="Éditer">
                  <i class="bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-white btn-sm text-success" data-bs-toggle="modal" data-bs-target="#depositModal{{ $user->id }}" title="Recharger le compte">
                  <i class="bi-cash-stack"></i>
                </button>
              </div>

              <!-- Deposit Modal -->
              <div class="modal fade" id="depositModal{{ $user->id }}" tabindex="-1" aria-labelledby="depositModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="{{ route('admin.users.deposit', $user->id) }}" method="POST">
                      @csrf
                      <div class="modal-header">
                        <h5 class="modal-title" id="depositModalLabel{{ $user->id }}">Recharger le compte de {{ $user->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-start">
                        <div class="alert alert-soft-info">
                          <i class="bi-info-circle-fill me-1"></i> Ce dépôt manuel attribuera automatiquement le capital et les parts (après déduction des 2% de frais d'entrée).
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="montant{{ $user->id }}">Montant du dépôt (USD) <span class="text-danger">*</span></label>
                          <input type="number" step="0.01" min="0.01" class="form-control" id="montant{{ $user->id }}" name="montant" required placeholder="Ex: 1000">
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="description{{ $user->id }}">Description / Notes (optionnel)</label>
                          <textarea class="form-control" id="description{{ $user->id }}" name="description" rows="2" placeholder="Ex: Dépôt en espèces remis en main propre..."></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Confirmer le dépôt</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <!-- End Deposit Modal -->
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      {{ $users->links() }}
    </div>
  </div>
</div>

@endsection
