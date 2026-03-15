<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste des tickets du membre connecté.
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->with('latestMessage')
            ->orderByDesc('updated_at')
            ->get();

        return view('support.index', compact('tickets'));
    }

    /**
     * Formulaire de création d'un ticket.
     */
    public function create()
    {
        return view('support.create');
    }

    /**
     * Enregistre un nouveau ticket + premier message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject'  => 'required|string|max:255',
            'category' => 'required|in:general,depot,retrait,investissement,kyc,technique',
            'priority' => 'required|in:low,medium,high',
            'body'     => 'required|string|max:5000',
        ]);

        $ticket = SupportTicket::create([
            'user_id'  => Auth::id(),
            'subject'  => $request->subject,
            'category' => $request->category,
            'priority' => $request->priority,
            'status'   => 'open',
        ]);

        SupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'body'      => $request->body,
            'is_admin'  => false,
        ]);

        return redirect()->route('support.show', $ticket)
            ->with('success', 'Votre ticket a été créé. Un administrateur vous répondra rapidement.');
    }

    /**
     * Affiche un ticket et ses messages (conversation).
     */
    public function show(SupportTicket $ticket)
    {
        // Seul le propriétaire ou un admin peut voir
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $messages = $ticket->messages()->with('user')->orderBy('created_at', 'asc')->get();

        // Marquer les messages non-lus de l'autre partie comme lus
        $ticket->messages()
            ->whereNull('read_at')
            ->where('user_id', '!=', Auth::id())
            ->update(['read_at' => now()]);

        return view('support.show', compact('ticket', 'messages'));
    }

    /**
     * Envoie un message dans un ticket existant.
     */
    public function reply(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $isAdmin = Auth::user()->role === 'admin';

        SupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'body'      => $request->body,
            'is_admin'  => $isAdmin,
        ]);

        // Si admin répond, passer en "in_progress"
        if ($isAdmin && $ticket->status === 'open') {
            $ticket->update([
                'status'      => 'in_progress',
                'assigned_to' => Auth::id(),
            ]);
        }

        $ticket->touch();

        return back()->with('success', 'Message envoyé.');
    }

    /**
     * Fermer un ticket (membre ou admin).
     */
    public function close(SupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $ticket->update([
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Ticket fermé.');
    }
}
