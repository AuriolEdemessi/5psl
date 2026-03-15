@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a href="{{ route('admin.kyc.index') }}">KYC</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
          </ol>
        </nav>
        <h1 class="page-header-title">Dossier KYC de {{ $user->name }}</h1>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- User Info Card -->
    <div class="col-lg-4 mb-3 mb-lg-5">
      <div class="card text-center">
        <div class="card-body">
          <div class="avatar avatar-xl avatar-primary avatar-circle mx-auto mb-3">
            <span class="avatar-initials">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
          </div>
          <h4>{{ $user->name }}</h4>
          <p class="text-muted">{{ $user->email }}</p>

          <div class="bg-light rounded p-3 mb-3">
            <small class="text-cap">Statut actuel</small>
            @if($user->kyc_status === 'verified')
              <div class="text-success fw-bold"><i class="bi-check-circle-fill me-1"></i> VÉRIFIÉ</div>
            @elseif($user->kyc_status === 'pending')
              <div class="text-warning fw-bold"><i class="bi-clock-fill me-1"></i> EN ATTENTE</div>
            @elseif($user->kyc_status === 'rejected')
              <div class="text-danger fw-bold"><i class="bi-x-circle-fill me-1"></i> REJETÉ</div>
            @else
              <div class="text-secondary fw-bold">NON SOUMIS</div>
            @endif
          </div>

          @if($user->kyc_status === 'pending' || $user->kyc_status === 'rejected')
          <div class="d-grid gap-2">
            <form action="{{ route('admin.kyc.verify', $user->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-success w-100" onclick="return confirm('Valider ce compte ?');">
                <i class="bi-check-lg me-1"></i> Valider l'identité
              </button>
            </form>
            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
              <i class="bi-x-lg me-1"></i> Rejeter le dossier
            </button>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Documents -->
    <div class="col-lg-8 mb-3 mb-lg-5">
      <div class="card">
        <div class="card-header">
          <h4 class="card-header-title">Documents soumis ({{ $documents->count() }})</h4>
        </div>
        <div class="card-body">
          @forelse($documents as $doc)
          <div class="card mb-3 {{ $loop->first ? 'border-primary' : '' }}">
            <div class="card-body">
              @if($loop->first)
                <span class="badge bg-primary position-absolute" style="top: -8px; right: 16px;">Plus récent</span>
              @endif

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <h5 class="mb-1">
                    @if($doc->document_type == 'id_card')
                      <i class="bi-person-vcard me-2 text-primary"></i>Carte d'Identité
                    @elseif($doc->document_type == 'passport')
                      <i class="bi-passport me-2 text-primary"></i>Passeport
                    @else
                      <i class="bi-card-text me-2 text-primary"></i>Permis de Conduire
                    @endif
                  </h5>
                  <small class="text-muted">Soumis le {{ $doc->created_at->format('d/m/Y à H:i') }}</small>
                </div>
                <a href="{{ route('admin.kyc.download', $doc->id) }}" class="btn btn-white btn-sm">
                  <i class="bi-download me-1"></i> Télécharger
                </a>
              </div>

              @if($doc->rejection_reason)
              <div class="alert alert-soft-danger">
                <strong>Raison du rejet :</strong> {{ $doc->rejection_reason }}
              </div>
              @endif

              @if(Str::endsWith(strtolower($doc->file_path), ['.jpg', '.jpeg', '.png']))
              <div class="text-center bg-light rounded p-2">
                <img src="{{ route('admin.kyc.download', $doc->id) }}" style="max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 4px;" alt="Aperçu">
              </div>
              @elseif(Str::endsWith(strtolower($doc->file_path), ['.pdf']))
              <div class="text-center bg-light rounded p-4">
                <i class="bi-file-earmark-pdf" style="font-size: 2.5rem; color: #dc3545;"></i>
                <p class="mt-2 mb-0 text-muted">Document PDF — téléchargez pour visualiser.</p>
              </div>
              @endif
            </div>
          </div>
          @empty
          <div class="text-center py-5">
            <i class="bi-folder2-open" style="font-size: 3rem; color: #bdc5d1;"></i>
            <h4 class="mt-3">Aucun document</h4>
            <p class="text-muted">Cet utilisateur n'a soumis aucun document d'identité.</p>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi-x-circle text-danger me-2"></i>Rejeter le dossier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Raison du rejet</label>
            <select class="form-select mb-2" onchange="document.getElementById('reason_text').value = this.value;">
              <option value="">-- Raison rapide --</option>
              <option value="Document illisible ou flou.">Document illisible ou flou.</option>
              <option value="Document expiré.">Document expiré.</option>
              <option value="Informations non visibles (coins coupés).">Informations non visibles (coins coupés).</option>
              <option value="Le nom ne correspond pas au compte.">Le nom ne correspond pas au compte.</option>
              <option value="Type de document non accepté.">Type de document non accepté.</option>
            </select>
            <textarea name="reason" id="reason_text" class="form-control" rows="3" placeholder="Raison détaillée..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-white" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
