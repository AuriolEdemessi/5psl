@extends('layouts.dashboard')
@section('title', 'Assistance')

@section('content')

{{-- Header --}}
<div class="section-header animate-fade-in-up">
    <div>
        <h2 class="section-title-sm">Assistance</h2>
        <p class="section-subtitle">Besoin d'aide ? Créez un ticket et un administrateur vous répondra rapidement.</p>
    </div>
    <a href="{{ route('support.create') }}" class="btn-possible btn-possible-primary btn-possible-sm">
        <i class="fas fa-plus"></i> Nouveau ticket
    </a>
</div>

{{-- Tickets list --}}
<div class="card-5psl animate-fade-in-up delay-1" style="padding: 0; overflow: hidden;">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between;">
        <h4 style="font-size: 15px; font-weight: 800; margin: 0;">Mes Tickets</h4>
        <span class="badge-5psl badge-dark">{{ $tickets->count() }} ticket(s)</span>
    </div>

    @forelse($tickets as $ticket)
        @php
            $statusColors = ['open' => ['#dc2626','#fef2f2','Ouvert'], 'in_progress' => ['#d97706','#fffbeb','En cours'], 'resolved' => ['#059669','#ecfdf5','Résolu'], 'closed' => ['#6b7280','#f3f4f6','Fermé']];
            $sc = $statusColors[$ticket->status] ?? ['#6b7280','#f3f4f6','—'];
            $unread = $ticket->unreadCountFor(auth()->user());
        @endphp
        <a href="{{ route('support.show', $ticket) }}" style="display: block; padding: 16px 24px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: background 0.15s;"
           onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                        <span style="font-weight: 800; font-size: 14px; color: var(--possible-dark);">{{ $ticket->subject }}</span>
                        @if($unread > 0)
                            <span style="background: var(--possible-blue); color: white; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 10px;">{{ $unread }}</span>
                        @endif
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: var(--color-muted);">
                        <span><i class="fas fa-tag me-1"></i>{{ ucfirst($ticket->category) }}</span>
                        <span><i class="fas fa-clock me-1"></i>{{ $ticket->updated_at->diffForHumans() }}</span>
                        @if($ticket->latestMessage)
                            <span style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ Str::limit($ticket->latestMessage->body, 50) }}
                            </span>
                        @endif
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-shrink: 0;">
                    <span class="badge-5psl" style="background: {{ $sc[1] }}; color: {{ $sc[0] }};">{{ $sc[2] }}</span>
                    <i class="fas fa-chevron-right" style="color: var(--color-muted); font-size: 12px;"></i>
                </div>
            </div>
        </a>
    @empty
        <div class="empty-state" style="padding: 48px 20px;">
            <div class="empty-state-icon"><i class="fas fa-headset"></i></div>
            <h4>Aucun ticket</h4>
            <p>Vous n'avez pas encore créé de demande d'assistance.</p>
            <a href="{{ route('support.create') }}" class="btn-possible btn-possible-primary btn-possible-sm mt-3">
                <i class="fas fa-plus"></i> Créer un ticket
            </a>
        </div>
    @endforelse
</div>

@endsection
