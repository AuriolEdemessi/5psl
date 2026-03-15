@extends('layouts.dashboard')
@section('title', 'Ticket #' . $ticket->id)

@section('content')

@php
    $user = auth()->user();
    $isAdmin = $user->role === 'admin';
    $statusColors = ['open' => ['#dc2626','#fef2f2','Ouvert'], 'in_progress' => ['#d97706','#fffbeb','En cours'], 'resolved' => ['#059669','#ecfdf5','Résolu'], 'closed' => ['#6b7280','#f3f4f6','Fermé']];
    $sc = $statusColors[$ticket->status] ?? ['#6b7280','#f3f4f6','—'];
    $priorityColors = ['high' => '#dc2626', 'medium' => '#d97706', 'low' => '#6b7280'];
@endphp

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
            <h2 class="section-title-sm" style="margin: 0;">{{ $ticket->subject }}</h2>
            <span class="badge-5psl" style="background: {{ $sc[1] }}; color: {{ $sc[0] }};">{{ $sc[2] }}</span>
        </div>
        <p class="section-subtitle">
            Ticket #{{ $ticket->id }} — {{ ucfirst($ticket->category) }} —
            <span style="color: {{ $priorityColors[$ticket->priority] ?? '#6b7280' }}; font-weight: 700;">Priorité {{ $ticket->priority }}</span>
            — Créé {{ $ticket->created_at->diffForHumans() }}
        </p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        @if($isAdmin)
            <a href="{{ route('admin.support.index') }}" class="btn-possible btn-possible-outline btn-possible-sm">
                <i class="fas fa-arrow-left"></i> Admin Support
            </a>
        @else
            <a href="{{ route('support.index') }}" class="btn-possible btn-possible-outline btn-possible-sm">
                <i class="fas fa-arrow-left"></i> Mes tickets
            </a>
        @endif
        @if($ticket->isOpen())
            <form action="{{ route('support.close', $ticket) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-possible btn-possible-sm" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;">
                    <i class="fas fa-times"></i> Fermer
                </button>
            </form>
        @endif
    </div>
</div>

<div class="row g-3">
    {{-- Conversation --}}
    <div class="col-lg-8">
        <div class="card-5psl animate-fade-in-up delay-1" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-comments me-2" style="color: var(--possible-blue);"></i>Conversation</h4>
            </div>

            {{-- Messages --}}
            <div id="messagesContainer" style="max-height: 500px; overflow-y: auto; padding: 16px 24px;">
                @foreach($messages as $msg)
                    @php $isMine = $msg->user_id === $user->id; @endphp
                    <div style="display: flex; justify-content: {{ $isMine ? 'flex-end' : 'flex-start' }}; margin-bottom: 16px;">
                        <div style="max-width: 75%; display: flex; flex-direction: column; align-items: {{ $isMine ? 'flex-end' : 'flex-start' }};">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                @if(!$isMine)
                                    <div style="width: 24px; height: 24px; border-radius: 6px; background: {{ $msg->is_admin ? '#0066ff' : 'rgba(0,102,255,0.08)' }}; color: {{ $msg->is_admin ? 'white' : 'var(--possible-blue)' }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 10px;">
                                        {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span style="font-size: 11px; font-weight: 700; color: var(--color-muted);">
                                    {{ $msg->user->name }}
                                    @if($msg->is_admin)
                                        <span style="color: var(--possible-blue); font-size: 9px; background: rgba(0,102,255,0.08); padding: 1px 5px; border-radius: 3px; margin-left: 4px;">Admin</span>
                                    @endif
                                </span>
                                <span style="font-size: 10px; color: var(--color-muted);">{{ $msg->created_at->format('d/m H:i') }}</span>
                            </div>
                            <div style="
                                padding: 12px 16px;
                                border-radius: 12px;
                                {{ $isMine ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;' }}
                                background: {{ $isMine ? ($msg->is_admin ? 'var(--possible-blue)' : 'var(--possible-dark)') : '#f1f5f9' }};
                                color: {{ $isMine ? 'white' : 'var(--possible-dark)' }};
                                font-size: 13px;
                                line-height: 1.6;
                                word-break: break-word;
                            ">
                                {!! nl2br(e($msg->body)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Reply form --}}
            @if($ticket->isOpen())
                <div style="padding: 16px 24px; border-top: 1px solid var(--color-border); background: #fafbfc;">
                    <form action="{{ route('support.reply', $ticket) }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 10px;">
                            <textarea name="body" class="input-5psl" rows="2" required placeholder="Tapez votre message..."
                                style="flex: 1; resize: none; font-size: 13px;"></textarea>
                            <button type="submit" class="btn-possible btn-possible-primary" style="align-self: flex-end; padding: 10px 18px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div style="padding: 16px 24px; border-top: 1px solid var(--color-border); background: #f8fafc; text-align: center;">
                    <span style="font-size: 13px; color: var(--color-muted); font-weight: 600;">
                        <i class="fas fa-lock me-1"></i> Ce ticket est fermé. Créez un nouveau ticket si nécessaire.
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar info --}}
    <div class="col-lg-4">
        <div class="card-5psl animate-slide-right delay-2" style="padding: 0; overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
                <h4 style="font-size: 14px; font-weight: 800; margin: 0;"><i class="fas fa-info-circle me-2" style="color: var(--possible-blue);"></i>Détails du ticket</h4>
            </div>
            <div style="padding: 16px 24px;">
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">ID</span>
                    <span style="font-size: 13px; font-weight: 700;">#{{ $ticket->id }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Statut</span>
                    <span class="badge-5psl" style="background: {{ $sc[1] }}; color: {{ $sc[0] }};">{{ $sc[2] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Catégorie</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ ucfirst($ticket->category) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Priorité</span>
                    <span style="font-size: 13px; font-weight: 700; color: {{ $priorityColors[$ticket->priority] ?? '#6b7280' }};">{{ ucfirst($ticket->priority) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Créé par</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ $ticket->user->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Assigné à</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ $ticket->assignedAdmin->name ?? 'Non assigné' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9;">
                    <span style="font-size: 12px; color: var(--color-muted);">Créé le</span>
                    <span style="font-size: 13px;">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                    <span style="font-size: 12px; color: var(--color-muted);">Messages</span>
                    <span style="font-size: 13px; font-weight: 700;">{{ $messages->count() }}</span>
                </div>
            </div>
        </div>

        {{-- Admin: status change --}}
        @if($isAdmin && $ticket->isOpen())
            <div class="card-5psl mt-3 animate-slide-right delay-3" style="padding: 18px;">
                <h4 style="font-size: 13px; font-weight: 800; margin-bottom: 12px;"><i class="fas fa-cog me-2"></i>Actions admin</h4>
                <form action="{{ route('admin.support.status', $ticket) }}" method="POST" style="display: flex; gap: 8px;">
                    @csrf
                    <select name="status" class="input-5psl" style="flex: 1; padding: 8px; font-size: 12px;">
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="resolved">Résolu</option>
                        <option value="closed">Fermé</option>
                    </select>
                    <button type="submit" class="btn-possible btn-possible-primary btn-possible-sm">Mettre à jour</button>
                </form>
                @if(!$ticket->assigned_to)
                    <form action="{{ route('admin.support.assign', $ticket) }}" method="POST" style="margin-top: 8px;">
                        @csrf
                        <button type="submit" class="btn-possible btn-possible-sm w-100" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">
                            <i class="fas fa-hand-pointer me-1"></i> M'assigner ce ticket
                        </button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Auto-scroll to bottom of messages
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messagesContainer');
        if (container) container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
