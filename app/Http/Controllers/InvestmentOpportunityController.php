<?php

namespace App\Http\Controllers;

use App\Models\InvestmentOpportunity;
use App\Models\OpportunityVote;
use App\Models\User;
use App\Notifications\NewOpportunityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class InvestmentOpportunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste de toutes les opportunités d'investissement
     */
    public function index()
    {
        $opportunities = InvestmentOpportunity::withCount(['votes as approvals_count' => function ($q) {
            $q->where('vote', 'approuver');
        }, 'votes as rejections_count' => function ($q) {
            $q->where('vote', 'rejeter');
        }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('investment.opportunities.index', compact('opportunities'));
    }

    /**
     * Formulaire de création (admin uniquement)
     */
    public function create()
    {
        return view('investment.opportunities.create');
    }

    /**
     * Enregistrement d'une nouvelle opportunité + envoi de notifications
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:action,obligation,crypto,immobilier,fonds,autre',
            'montant_estime' => 'nullable|numeric|min:0',
            'date_limite_vote' => 'nullable|date|after:today',
        ]);

        $opportunity = InvestmentOpportunity::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'montant_estime' => $request->montant_estime,
            'date_limite_vote' => $request->date_limite_vote,
            'created_by' => Auth::id(),
        ]);

        // Envoyer une notification email à tous les membres
        $users = User::where('id', '!=', Auth::id())->get();
        Notification::send($users, new NewOpportunityNotification($opportunity));

        return redirect()->route('opportunities.index')
            ->with('success', 'Opportunité publiée et notifications envoyées à tous les membres !');
    }

    /**
     * Détail d'une opportunité
     */
    public function show(InvestmentOpportunity $opportunity)
    {
        $opportunity->loadCount(['votes as approvals_count' => function ($q) {
            $q->where('vote', 'approuver');
        }, 'votes as rejections_count' => function ($q) {
            $q->where('vote', 'rejeter');
        }]);

        $userVote = $opportunity->getUserVote(Auth::id());

        return view('investment.opportunities.show', compact('opportunity', 'userVote'));
    }

    /**
     * Vote sur une opportunité (approuver/rejeter)
     */
    public function vote(Request $request, InvestmentOpportunity $opportunity)
    {
        $request->validate([
            'vote' => 'required|in:approuver,rejeter',
        ]);

        if ($opportunity->statut !== 'ouverte') {
            return back()->with('error', 'Cette opportunité n\'est plus ouverte au vote.');
        }

        if ($opportunity->hasUserVoted(Auth::id())) {
            return back()->with('error', 'Vous avez déjà voté pour cette opportunité.');
        }

        OpportunityVote::create([
            'investment_opportunity_id' => $opportunity->id,
            'user_id' => Auth::id(),
            'vote' => $request->vote,
        ]);

        return back()->with('success', 'Vote enregistré avec succès !');
    }
}
