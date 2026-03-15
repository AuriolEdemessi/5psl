@extends('layouts.dashboard')
@section('title', 'Gestion des Utilisateurs')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Membres et Administrateurs</h2>
        <p class="section-subtitle">Gérez les utilisateurs de la plateforme, leurs rôles et leurs niveaux.</p>
    </div>
    <div>
        <a href="{{ route('admin.users.create') }}" class="btn-possible" style="font-size: 13px;">
            <i class="fas fa-plus me-1"></i> Nouvel Admin/Membre
        </a>
    </div>
</div>

<div class="card-5psl" style="padding: 0; overflow: hidden;">
    <div class="table-responsive">
        <table class="table-5psl mb-0">
            <thead>
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
                        <td style="font-weight: 700; font-size: 13px;">{{ $user->name }}</td>
                        <td style="font-size: 13px; color: var(--color-muted);">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin' || $user->role === 'superadmin')
                                <span class="badge-5psl badge-success" style="font-size: 10px;">{{ strtoupper($user->role) }}</span>
                            @else
                                <span class="badge-5psl" style="background: #f1f5f9; color: #64748b; font-size: 10px;">MEMBER</span>
                            @endif
                        </td>
                        <td>
                            @if($user->tier === 'ELITE')
                                <span style="color: #f59e0b; font-weight: 800; font-size: 12px;"><i class="fas fa-crown me-1"></i>ELITE</span>
                            @elseif($user->tier === 'PRO')
                                <span style="color: var(--possible-blue); font-weight: 800; font-size: 12px;">PRO</span>
                            @else
                                <span style="color: #64748b; font-weight: 800; font-size: 12px;">STARTER</span>
                            @endif
                        </td>
                        <td>
                            @if($user->kyc_status === 'verified')
                                <span style="color: var(--color-success);"><i class="fas fa-check-circle"></i></span>
                            @elseif($user->kyc_status === 'pending')
                                <span style="color: var(--color-warning);"><i class="fas fa-clock"></i></span>
                            @else
                                <span style="color: var(--color-danger);"><i class="fas fa-times-circle"></i></span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-possible btn-possible-sm" style="background: #f1f5f9; color: var(--possible-dark); font-size: 11px;">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    {{ $users->links() }}
</div>

@endsection
