@extends('layouts.dashboard')
@section('title', 'Détail de l\'opportunité')

@section('content')

<div class="section-header">
    <div>
        <h2 class="section-title-sm">Détail de l'opportunité</h2>
        <p style="color: #666; font-size: 14px; margin-top: 4px;">Analysez le projet et exprimez votre vote.</p>
    </div>
    <a href="{{ route('opportunities.index') }}" class="btn-possible btn-possible-outline">
        <i class="fas fa-arrow-left me-2"></i>Retour aux opportunités
    </a>
</div>


<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-5psl">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #eee;">
                <div>
                    <div style="display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; margin-bottom: 12px; background: rgba(0,102,255,0.1); color: var(--possible-blue);">
                        {{ ucfirst($opportunity->type) }}
                    </div>
                    <h3 style="font-size: 28px; font-weight: 900; color: var(--possible-dark); margin: 0; letter-spacing: -0.5px;">{{ $opportunity->titre }}</h3>
                </div>
                @if($opportunity->statut === 'ouverte')
                    <span class="badge-5psl badge-success"><i class="fas fa-lock-open me-1"></i>Ouvert au vote</span>
                @elseif($opportunity->statut === 'approuvee')
                    <span class="badge-5psl" style="background: rgba(0,255,0,0.1); color: #059669;"><i class="fas fa-check-circle me-1"></i>Approuvé</span>
                @else
                    <span class="badge-5psl badge-danger"><i class="fas fa-times-circle me-1"></i>Rejeté</span>
                @endif
            </div>

            <div style="margin-bottom: 32px;">
                <h4 style="font-size: 16px; font-weight: 800; margin-bottom: 16px; color: var(--possible-dark);">Description du projet</h4>
                <div style="color: #444; font-size: 15px; line-height: 1.8; white-space: pre-wrap;">{{ $opportunity->description }}</div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div style="background: #f8fafc; border-radius: 8px; padding: 20px; height: 100%;">
                        <div style="font-size: 13px; color: #666; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Montant Estimé Requis</div>
                        <div style="font-size: 24px; font-weight: 900; color: var(--possible-dark);">
                            {{ $opportunity->montant_estime ? number_format((float)$opportunity->montant_estime, 2, ',', ' ') . ' FCFA' : 'À définir' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="background: #f8fafc; border-radius: 8px; padding: 20px; height: 100%;">
                        <div style="font-size: 13px; color: #666; font-weight: 600; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Date Limite de Vote</div>
                        <div style="font-size: 20px; font-weight: 800; color: {{ \Carbon\Carbon::parse($opportunity->date_limite_vote)->isPast() ? '#dc2626' : 'var(--possible-dark)' }};">
                            {{ $opportunity->date_limite_vote ? \Carbon\Carbon::parse($opportunity->date_limite_vote)->format('d M, Y') : 'Non définie' }}
                        </div>
                        @if($opportunity->date_limite_vote && \Carbon\Carbon::parse($opportunity->date_limite_vote)->isFuture())
                            <div style="font-size: 13px; color: #666; margin-top: 4px;">
                                Dans {{ \Carbon\Carbon::parse($opportunity->date_limite_vote)->diffForHumans(['parts' => 2]) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-5psl" style="position: sticky; top: 100px;">
            <h4 style="font-size: 18px; font-weight: 800; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #eee;">Résultats du Vote</h4>

            @php
                $totalVotes = $opportunity->approvals_count + $opportunity->rejections_count;
                $approvalPercentage = $totalVotes > 0 ? ($opportunity->approvals_count / $totalVotes) * 100 : 0;
                $rejectionPercentage = $totalVotes > 0 ? ($opportunity->rejections_count / $totalVotes) * 100 : 0;
            @endphp

            <div style="margin-bottom: 32px;">
                <div style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 800; margin-bottom: 12px;">
                    <span style="color: #059669;"><i class="fas fa-thumbs-up me-2"></i>Pour ({{ number_format($approvalPercentage, 1) }}%)</span>
                    <span style="color: #dc2626;"><i class="fas fa-thumbs-down me-2"></i>Contre ({{ number_format($rejectionPercentage, 1) }}%)</span>
                </div>
                <div style="height: 12px; background: #eee; border-radius: 6px; display: flex; overflow: hidden; margin-bottom: 16px;">
                    <div style="height: 100%; background: #059669; width: {{ $approvalPercentage }}%; transition: width 1s ease-in-out;"></div>
                    <div style="height: 100%; background: #dc2626; width: {{ $rejectionPercentage }}%; transition: width 1s ease-in-out;"></div>
                </div>
                <div style="text-align: center; font-size: 14px; color: #666; font-weight: 600;">
                    Participation : {{ $totalVotes }} membre(s)
                </div>
            </div>

            @if($opportunity->statut === 'ouverte')
                @if($userVote)
                    <div style="background: rgba(0, 102, 255, 0.05); border: 1px solid rgba(0, 102, 255, 0.1); padding: 20px; border-radius: 8px; text-align: center;">
                        <div style="width: 48px; height: 48px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: {{ $userVote->vote === 'approuver' ? '#059669' : '#dc2626' }}; font-size: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                            <i class="fas {{ $userVote->vote === 'approuver' ? 'fa-thumbs-up' : 'fa-thumbs-down' }}"></i>
                        </div>
                        <h5 style="font-size: 15px; font-weight: 800; margin-bottom: 4px;">Vous avez déjà voté</h5>
                        <p style="font-size: 13px; color: #666; margin: 0;">
                            Votre choix : <strong style="color: {{ $userVote->vote === 'approuver' ? '#059669' : '#dc2626' }}; text-transform: uppercase;">{{ $userVote->vote }}</strong>
                        </p>
                    </div>
                @else
                    <form action="{{ route('opportunities.vote', $opportunity) }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <button type="submit" name="vote" value="approuver" class="btn-possible" style="background: rgba(0,255,0,0.1); color: #059669; width: 100%; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='#059669'" onmouseout="this.style.borderColor='transparent'">
                                <i class="fas fa-thumbs-up me-2"></i>Je vote POUR
                            </button>
                            <button type="submit" name="vote" value="rejeter" class="btn-possible" style="background: rgba(255,51,51,0.1); color: #dc2626; width: 100%; border: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderColor='#dc2626'" onmouseout="this.style.borderColor='transparent'">
                                <i class="fas fa-thumbs-down me-2"></i>Je vote CONTRE
                            </button>
                        </div>
                    </form>
                @endif
            @else
                <div style="background: #f8fafc; padding: 20px; border-radius: 8px; text-align: center;">
                    <i class="fas fa-lock" style="font-size: 24px; color: #94a3b8; margin-bottom: 12px;"></i>
                    <p style="font-size: 14px; font-weight: 600; color: #666; margin: 0;">Les votes sont clôturés pour cette opportunité.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
