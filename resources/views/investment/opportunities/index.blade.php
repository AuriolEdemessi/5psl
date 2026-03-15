@extends('layouts.dashboard')
@section('title', 'Opportunités d\'Investissement')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Opportunités & Votes</h2>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Participez aux décisions d'investissement du club. Chaque voix compte.</p>
    </div>
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('opportunities.create') }}" class="btn-possible btn-possible-success">
            <i class="fas fa-plus me-2"></i>Nouvelle Opportunité
        </a>
    @endif
</div>


<div class="row g-4">
    @forelse($opportunities as $opportunity)
        <div class="col-lg-6">
            <div class="card-5psl" style="height: 100%; display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                    <div>
                        <div style="display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; background: rgba(0,102,255,0.1); color: var(--possible-blue);">
                            {{ ucfirst($opportunity->type) }}
                        </div>
                        <h4 style="font-size: 20px; font-weight: 800; color: var(--possible-dark); margin: 0;">{{ $opportunity->titre }}</h4>
                    </div>
                    @if($opportunity->statut === 'ouverte')
                        <span class="badge-5psl badge-success" style="font-size: 12px;"><i class="fas fa-lock-open me-1"></i>Ouvert</span>
                    @elseif($opportunity->statut === 'approuvee')
                        <span class="badge-5psl" style="background: rgba(0,255,0,0.1); color: #059669; font-size: 12px;"><i class="fas fa-check-circle me-1"></i>Approuvé</span>
                    @else
                        <span class="badge-5psl badge-danger" style="font-size: 12px;"><i class="fas fa-times-circle me-1"></i>Rejeté</span>
                    @endif
                </div>

                <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 24px; flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $opportunity->description }}
                </p>

                <div style="background: #f8fafc; border-radius: 8px; padding: 16px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-size: 13px; color: #666; font-weight: 600;">Montant Estimé :</span>
                        <span style="font-size: 16px; font-weight: 800; color: var(--possible-dark);">
                            {{ $opportunity->montant_estime ? number_format((float)$opportunity->montant_estime, 2, ',', ' ') . ' FCFA' : 'Non défini' }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 13px; color: #666; font-weight: 600;">Date limite :</span>
                        <span style="font-size: 14px; font-weight: 700; color: #dc2626;">
                            {{ $opportunity->date_limite_vote ? \Carbon\Carbon::parse($opportunity->date_limite_vote)->format('d M, Y') : 'Non définie' }}
                        </span>
                    </div>
                </div>

                @php
                    $totalVotes = $opportunity->approvals_count + $opportunity->rejections_count;
                    $approvalPercentage = $totalVotes > 0 ? ($opportunity->approvals_count / $totalVotes) * 100 : 0;
                    $rejectionPercentage = $totalVotes > 0 ? ($opportunity->rejections_count / $totalVotes) * 100 : 0;
                @endphp

                <div style="margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                        <span style="color: #059669;">Pour ({{ number_format($approvalPercentage, 1) }}%)</span>
                        <span style="color: #dc2626;">Contre ({{ number_format($rejectionPercentage, 1) }}%)</span>
                    </div>
                    <div style="height: 8px; background: #eee; border-radius: 4px; display: flex; overflow: hidden;">
                        <div style="height: 100%; background: #059669; width: {{ $approvalPercentage }}%;"></div>
                        <div style="height: 100%; background: #dc2626; width: {{ $rejectionPercentage }}%;"></div>
                    </div>
                    <div style="text-align: center; font-size: 12px; color: #666; margin-top: 8px;">
                        {{ $totalVotes }} vote(s) au total
                    </div>
                </div>

                <a href="{{ route('opportunities.show', $opportunity) }}" class="btn-possible w-100 text-center" style="padding: 12px;">
                    Voir les détails & Voter
                </a>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card-5psl text-center" style="padding: 60px 20px;">
                <div style="width: 80px; height: 80px; background: rgba(0,102,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--possible-blue); font-size: 32px;">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 12px;">Aucune opportunité pour le moment</h3>
                <p style="color: #666; font-size: 15px; max-width: 400px; margin: 0 auto;">Les administrateurs publieront bientôt de nouvelles opportunités d'investissement à soumettre aux votes.</p>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $opportunities->links() }}
</div>

@endsection
