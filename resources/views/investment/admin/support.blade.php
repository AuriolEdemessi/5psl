@extends('layouts.dashboard')
@section('title', 'Support — Admin')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Gestion du Support</h2>
        <p class="section-subtitle">Répondez aux demandes d'assistance des membres du club.</p>
    </div>
</div>

{{-- Stats bar --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 animate-fade-in-up delay-1">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Ouverts</div>
                    <div class="kpi-value" style="color: #dc2626;">{{ $stats['open'] }}</div>
                </div>
                <div class="kpi-icon" style="background: #fef2f2; color: #dc2626; margin-bottom: 0;"><i class="fas fa-envelope-open"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-fade-in-up delay-2">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">En cours</div>
                    <div class="kpi-value" style="color: #d97706;">{{ $stats['in_progress'] }}</div>
                </div>
                <div class="kpi-icon" style="background: #fffbeb; color: #d97706; margin-bottom: 0;"><i class="fas fa-spinner"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-fade-in-up delay-3">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Résolus</div>
                    <div class="kpi-value" style="color: #059669;">{{ $stats['resolved'] }}</div>
                </div>
                <div class="kpi-icon" style="background: #ecfdf5; color: #059669; margin-bottom: 0;"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 animate-fade-in-up delay-4">
        <div class="card-5psl kpi-card">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value">{{ $stats['total'] }}</div>
                </div>
                <div class="kpi-icon" style="background: rgba(0,102,255,0.08); color: var(--possible-blue); margin-bottom: 0;"><i class="fas fa-headset"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="card-5psl mb-3 animate-fade-in-up delay-3" style="padding: 14px 20px;">
    <form method="GET" action="{{ route('admin.support.index') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <select name="status" class="input-5psl" style="width: auto; min-width: 140px; padding: 8px 12px; font-size: 13px;">
            <option value="">Tous statuts</option>
            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Ouvert</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Résolu</option>
            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Fermé</option>
        </select>
        <select name="category" class="input-5psl" style="width: auto; min-width: 140px; padding: 8px 12px; font-size: 13px;">
            <option value="">Toutes catégories</option>
            <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>Général</option>
            <option value="depot" {{ request('category') === 'depot' ? 'selected' : '' }}>Dépôt</option>
            <option value="retrait" {{ request('category') === 'retrait' ? 'selected' : '' }}>Retrait</option>
            <option value="investissement" {{ request('category') === 'investissement' ? 'selected' : '' }}>Investissement</option>
            <option value="kyc" {{ request('category') === 'kyc' ? 'selected' : '' }}>KYC</option>
            <option value="technique" {{ request('category') === 'technique' ? 'selected' : '' }}>Technique</option>
        </select>
        <select name="priority" class="input-5psl" style="width: auto; min-width: 120px; padding: 8px 12px; font-size: 13px;">
            <option value="">Toutes priorités</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Haute</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Moyenne</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Basse</option>
        </select>
        <button type="submit" class="btn-possible btn-possible-primary btn-possible-sm"><i class="fas fa-filter me-1"></i>Filtrer</button>
        <a href="{{ route('admin.support.index') }}" style="font-size: 12px; color: var(--color-muted); font-weight: 600;">Réinitialiser</a>
    </form>
</div>

{{-- Tickets table --}}
<div class="card-5psl animate-fade-in-up delay-4" style="padding: 0; overflow: hidden;">
    <div class="table-responsive">
        <table class="table-5psl">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Membre</th>
                    <th>Sujet</th>
                    <th>Catégorie</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Assigné</th>
                    <th>Dernier msg</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    @php
                        $statusColors = ['open' => ['#dc2626','#fef2f2'], 'in_progress' => ['#d97706','#fffbeb'], 'resolved' => ['#059669','#ecfdf5'], 'closed' => ['#6b7280','#f3f4f6']];
                        $statusLabels = ['open' => 'Ouvert', 'in_progress' => 'En cours', 'resolved' => 'Résolu', 'closed' => 'Fermé'];
                        $priorityColors = ['high' => '#dc2626', 'medium' => '#d97706', 'low' => '#6b7280'];
                        $sc = $statusColors[$ticket->status] ?? ['#6b7280','#f3f4f6'];
                    @endphp
                    <tr>
                        <td style="font-weight: 800; color: var(--color-muted); font-size: 12px;">#{{ $ticket->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 28px; height: 28px; border-radius: 6px; background: rgba(0,102,255,0.08); color: var(--possible-blue); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px;">
                                    {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 700; font-size: 13px;">{{ $ticket->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('support.show', $ticket) }}" style="font-weight: 700; font-size: 13px; color: var(--possible-dark);">
                                {{ Str::limit($ticket->subject, 40) }}
                            </a>
                        </td>
                        <td><span style="font-size: 11px; font-weight: 700; text-transform: capitalize;">{{ $ticket->category }}</span></td>
                        <td>
                            <span style="font-size: 11px; font-weight: 800; color: {{ $priorityColors[$ticket->priority] ?? '#6b7280' }};">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-5psl" style="background: {{ $sc[1] }}; color: {{ $sc[0] }};">{{ $statusLabels[$ticket->status] ?? $ticket->status }}</span>
                        </td>
                        <td style="font-size: 12px; color: var(--color-muted);">{{ $ticket->assignedAdmin->name ?? '—' }}</td>
                        <td style="font-size: 11px; color: var(--color-muted);">{{ $ticket->updated_at->diffForHumans() }}</td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                <a href="{{ route('support.show', $ticket) }}" class="btn-possible btn-possible-xs" style="background: rgba(0,102,255,0.08); color: var(--possible-blue); border: 1px solid rgba(0,102,255,0.15);">
                                    <i class="fas fa-comments"></i>
                                </a>
                                @if(!$ticket->assigned_to)
                                    <form action="{{ route('admin.support.assign', $ticket) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-possible btn-possible-xs" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;" title="S'assigner">
                                            <i class="fas fa-hand-pointer"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state" style="padding: 36px 20px;">
                                <div class="empty-state-icon"><i class="fas fa-headset"></i></div>
                                <h4>Aucun ticket</h4>
                                <p>Tous les tickets ont été traités.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tickets->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--color-border);">
            {{ $tickets->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection
