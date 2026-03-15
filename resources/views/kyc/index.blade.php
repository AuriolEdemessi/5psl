@extends('layouts.dashboard')
@section('title', 'Vérification KYC')

@section('content')

<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Vérification d'Identité (KYC)</h2>
        <p class="section-subtitle">Conformément à la réglementation, nous devons vérifier votre identité pour activer vos retraits et investissements.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7 animate-fade-in-up delay-1">
        <div class="card-5psl">
            <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 20px;"><i class="fas fa-shield-alt text-blue me-2"></i>Statut de votre KYC</h4>
            
            @if($user->kyc_status === 'verified')
                <div class="alert alert-success d-flex align-items-center" style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 20px;">
                    <i class="fas fa-check-circle fs-2 text-success me-3"></i>
                    <div>
                        <h5 class="mb-1 fw-bold text-success">Votre identité est vérifiée</h5>
                        <p class="mb-0 text-success" style="font-size: 13px;">Vous avez un accès complet à toutes les fonctionnalités de la plateforme.</p>
                    </div>
                </div>
            @elseif($user->kyc_status === 'pending')
                <div class="alert alert-warning d-flex align-items-center" style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 20px;">
                    <i class="fas fa-clock fs-2 text-warning me-3"></i>
                    <div>
                        <h5 class="mb-1 fw-bold text-warning">En cours de vérification</h5>
                        <p class="mb-0 text-warning" style="font-size: 13px;">Votre document a été soumis et est en cours d'examen par notre équipe. Cela prend généralement entre 24h et 48h.</p>
                    </div>
                </div>
            @else
                @if($user->kyc_status === 'rejected')
                    <div class="alert alert-danger d-flex align-items-center mb-4" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 20px;">
                        <i class="fas fa-times-circle fs-2 text-danger me-3"></i>
                        <div>
                            <h5 class="mb-1 fw-bold text-danger">Votre KYC a été rejeté</h5>
                            <p class="mb-0 text-danger" style="font-size: 13px;">
                                Raison : {{ $documents->first()->rejection_reason ?? 'Document illisible ou non valide.' }}
                            </p>
                        </div>
                    </div>
                @endif
                
                <div style="background: #f8fafc; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 13px;">Type de document</label>
                            <select name="document_type" class="form-select" style="font-size: 14px;" required>
                                <option value="id_card">Carte d'Identité Nationale (Recto/Verso)</option>
                                <option value="passport">Passeport</option>
                                <option value="driver_license">Permis de Conduire</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="font-size: 13px;">Télécharger le document</label>
                            <input type="file" name="document_file" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required style="font-size: 14px; padding: 10px;">
                            <div class="form-text" style="font-size: 11px; margin-top: 6px;">Format acceptés : JPG, PNG, PDF. Taille max : 5MB. Le document doit être clair et lisible en entier.</div>
                        </div>

                        <button type="submit" class="btn-possible btn-possible-primary w-100">
                            <i class="fas fa-upload me-2"></i> Soumettre le document
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    
    <div class="col-lg-5 animate-fade-in-up delay-2">
        <div class="card-5psl" style="background: #f8fafc; border: 1px dashed var(--color-border);">
            <h4 style="font-size: 14px; font-weight: 800; margin-bottom: 16px;"><i class="fas fa-info-circle text-blue me-2"></i>Conseils pour une validation rapide</h4>
            <ul style="font-size: 13px; color: #475569; padding-left: 16px; line-height: 1.8;">
                <li>Assurez-vous que le document est en cours de validité.</li>
                <li>Tous les coins du document doivent être visibles sur la photo.</li>
                <li>Évitez les reflets de lumière (flash) qui pourraient masquer des informations.</li>
                <li>Ne modifiez pas l'image avec un logiciel.</li>
                <li>Si vous soumettez une carte d'identité, veuillez scanner le recto et le verso sur le même document si possible, ou uploadez un PDF les contenant.</li>
            </ul>
        </div>
        
        @if($documents->count() > 0)
        <div class="card-5psl mt-4" style="padding: 0; overflow: hidden;">
            <div style="padding: 16px 20px; border-bottom: 1px solid var(--color-border); background: #f8fafc;">
                <h4 style="font-size: 13px; font-weight: 800; margin: 0;">Historique de vos soumissions</h4>
            </div>
            <div class="table-responsive">
                <table class="table-5psl mb-0">
                    <tbody>
                        @foreach($documents as $doc)
                        <tr>
                            <td style="font-size: 12px; color: #64748b;">{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                            <td style="font-size: 12px; font-weight: 600;">
                                @if($doc->document_type == 'id_card') Carte d'identité @elseif($doc->document_type == 'passport') Passeport @else Permis @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary" style="font-size: 10px;">Archivé</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
