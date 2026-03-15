@extends('layouts.dashboard')
@section('title', 'Gestion des KYC')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Vérifications KYC</h2>
        <p class="section-subtitle">Examinez et validez les documents d'identité soumis par les membres du club.</p>
    </div>
</div>

<div class="card-5psl" style="padding: 0; overflow: hidden;">
    <div style="padding: 16px 24px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
        <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-id-card me-2" style="color: var(--possible-blue);"></i>Dossiers soumis</h4>
    </div>
    
    <div class="table-responsive">
        <table class="table-5psl">
            <thead>
                <tr>
                    <th>Membre</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                    <th>Statut Actuel</th>
                    <th>Documents</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight: 700; font-size: 13px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 28px; height: 28px; border-radius: 6px; background: rgba(0,102,255,0.1); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td style="font-size: 12px; color: var(--color-muted);">{{ $user->email }}</td>
                        <td style="font-size: 12px;">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($user->kyc_status === 'verified')
                                <span class="badge-5psl badge-success"><i class="fas fa-check-circle me-1"></i> Vérifié</span>
                            @elseif($user->kyc_status === 'pending')
                                <span class="badge-5psl badge-warning"><i class="fas fa-clock me-1"></i> En attente</span>
                            @elseif($user->kyc_status === 'rejected')
                                <span class="badge-5psl badge-danger"><i class="fas fa-times-circle me-1"></i> Rejeté</span>
                            @else
                                <span class="badge-5psl" style="background: #f1f5f9; color: #64748b;">Non soumis</span>
                            @endif
                        </td>
                        <td style="font-size: 12px; font-weight: 600;">
                            {{ $user->kycDocuments->count() }} soumis
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.kyc.show', $user->id) }}" class="btn-possible btn-possible-sm" style="background: #f1f5f9; color: var(--possible-dark);">
                                Examiner <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fas fa-check-double"></i></div>
                                <h4>Aucun dossier</h4>
                                <p>Tous les dossiers ont été traités.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
