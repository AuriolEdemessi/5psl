@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Vérifications KYC</h1>
        <p class="page-header-text">Examinez et validez les documents d'identité soumis par les membres.</p>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h4 class="card-header-title"><i class="bi-person-check me-2"></i>Dossiers soumis</h4>
    </div>
    <div class="table-responsive">
      <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th>Membre</th>
            <th>Email</th>
            <th>Inscription</th>
            <th>Statut</th>
            <th>Documents</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
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
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>
              @if($user->kyc_status === 'verified')
                <span class="badge bg-soft-success text-success">Vérifié</span>
              @elseif($user->kyc_status === 'pending')
                <span class="badge bg-soft-warning text-warning">En attente</span>
              @elseif($user->kyc_status === 'rejected')
                <span class="badge bg-soft-danger text-danger">Rejeté</span>
              @else
                <span class="badge bg-soft-secondary text-secondary">Non soumis</span>
              @endif
            </td>
            <td><span class="badge bg-soft-info text-info">{{ $user->kycDocuments->count() }}</span></td>
            <td class="text-end">
              <a href="{{ route('admin.kyc.show', $user->id) }}" class="btn btn-white btn-sm">
                Examiner <i class="bi-arrow-right ms-1"></i>
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-5">
              <i class="bi-check2-all" style="font-size: 2rem;"></i>
              <p class="mt-2 mb-0">Aucun dossier KYC à examiner.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
