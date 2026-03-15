@extends('layouts.dashboard')
@section('title', 'Détails du KYC')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.kyc.index') }}" class="text-decoration-none" style="color: var(--color-muted); font-size: 13px; font-weight: 600;">
        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-5psl text-center">
            <div style="width: 64px; height: 64px; border-radius: 16px; background: rgba(0,102,255,0.1); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 24px; margin: 0 auto 16px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <h4 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;">{{ $user->name }}</h4>
            <div style="color: var(--color-muted); font-size: 13px; margin-bottom: 16px;">{{ $user->email }}</div>
            
            <div style="background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 4px;">Statut actuel</div>
                @if($user->kyc_status === 'verified')
                    <div style="color: #059669; font-weight: 800;"><i class="fas fa-check-circle me-1"></i> VÉRIFIÉ</div>
                @elseif($user->kyc_status === 'pending')
                    <div style="color: #d97706; font-weight: 800;"><i class="fas fa-clock me-1"></i> EN ATTENTE</div>
                @elseif($user->kyc_status === 'rejected')
                    <div style="color: #dc2626; font-weight: 800;"><i class="fas fa-times-circle me-1"></i> REJETÉ</div>
                @else
                    <div style="color: #64748b; font-weight: 800;">NON SOUMIS</div>
                @endif
            </div>

            @if($user->kyc_status === 'pending' || $user->kyc_status === 'rejected')
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.kyc.verify', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-possible w-100" style="background: #059669; color: white;" onclick="return confirm('Êtes-vous sûr de vouloir valider ce compte ?');">
                            <i class="fas fa-check me-2"></i> Valider l'identité
                        </button>
                    </form>
                    
                    <button type="button" class="btn-possible w-100" style="background: #fef2f2; color: #dc2626;" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fas fa-times me-2"></i> Rejeter le dossier
                    </button>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-8">
        <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 20px;">Documents soumis ({{ $documents->count() }})</h4>
        
        @forelse($documents as $doc)
            <div class="card-5psl mb-3" style="{{ $loop->first ? 'border: 2px solid var(--possible-blue);' : 'opacity: 0.7;' }}">
                @if($loop->first)
                    <div style="position: absolute; top: -10px; right: 20px; background: var(--possible-blue); color: white; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 12px; text-transform: uppercase;">Plus récent</div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div style="font-weight: 700; font-size: 14px;">
                            @if($doc->document_type == 'id_card')
                                <i class="fas fa-id-card text-blue me-2"></i> Carte d'Identité Nationale
                            @elseif($doc->document_type == 'passport')
                                <i class="fas fa-passport text-blue me-2"></i> Passeport
                            @else
                                <i class="fas fa-car text-blue me-2"></i> Permis de Conduire
                            @endif
                        </div>
                        <div style="font-size: 12px; color: var(--color-muted); margin-top: 4px;">
                            Soumis le {{ $doc->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                    <a href="{{ route('admin.kyc.download', $doc->id) }}" class="btn-possible btn-possible-sm" style="background: #f1f5f9; color: var(--possible-dark);">
                        <i class="fas fa-download me-1"></i> Télécharger
                    </a>
                </div>

                @if($doc->rejection_reason)
                    <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 12px; border-radius: 8px; margin-top: 12px; font-size: 12px;">
                        <strong style="color: #dc2626;">Raison du rejet précédent :</strong><br>
                        <span style="color: #991b1b;">{{ $doc->rejection_reason }}</span>
                    </div>
                @endif
                
                {{-- Aperçu de l'image si c'est une image --}}
                @if(Str::endsWith(strtolower($doc->file_path), ['.jpg', '.jpeg', '.png']))
                    <div style="margin-top: 20px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; background: #f8fafc; text-align: center; padding: 10px;">
                        <img src="{{ route('admin.kyc.download', $doc->id) }}" style="max-width: 100%; max-height: 400px; object-fit: contain; border-radius: 4px;" alt="Aperçu du document">
                    </div>
                @elseif(Str::endsWith(strtolower($doc->file_path), ['.pdf']))
                    <div style="margin-top: 20px; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; text-align: center; padding: 40px;">
                        <i class="fas fa-file-pdf fs-1 text-danger mb-3"></i>
                        <div style="font-weight: 600; font-size: 14px;">Document PDF</div>
                        <div style="font-size: 12px; color: var(--color-muted); margin-top: 4px;">Veuillez télécharger le fichier pour le visualiser.</div>
                    </div>
                @endif

            </div>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                <h4>Aucun document</h4>
                <p>Cet utilisateur n'a soumis aucun document d'identité.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 20px 24px;">
                <h5 class="modal-title fw-bold" style="font-size: 16px;"><i class="fas fa-times-circle text-danger me-2"></i>Rejeter le dossier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kyc.reject', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 24px;">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 13px;">Raison du rejet</label>
                        <select class="form-select mb-2" onchange="document.getElementById('reason_text').value = this.value;" style="font-size: 13px;">
                            <option value="">-- Choisir une raison rapide --</option>
                            <option value="Document illisible ou flou.">Document illisible ou flou.</option>
                            <option value="Document expiré.">Document expiré.</option>
                            <option value="Toutes les informations ne sont pas visibles (coins coupés).">Toutes les informations ne sont pas visibles (coins coupés).</option>
                            <option value="Le nom sur le document ne correspond pas au nom du compte.">Le nom sur le document ne correspond pas au nom du compte.</option>
                            <option value="Type de document non accepté.">Type de document non accepté.</option>
                        </select>
                        <textarea name="reason" id="reason_text" class="form-control" rows="3" placeholder="Saisissez ou modifiez la raison détaillée qui sera envoyée à l'utilisateur..." required style="font-size: 13px; resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f1f5f9; padding: 16px 24px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="font-weight: 600; font-size: 13px; border-radius: 8px;">Annuler</button>
                    <button type="submit" class="btn btn-danger" style="font-weight: 700; font-size: 13px; border-radius: 8px; padding: 8px 20px;">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
