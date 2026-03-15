<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSupportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Liste tous les tickets (admin).
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with(['user', 'latestMessage', 'assignedAdmin']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->orderByRaw("FIELD(status, 'open', 'in_progress', 'resolved', 'closed')")
            ->orderByDesc('updated_at')
            ->paginate(20);

        $stats = [
            'open'        => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved'    => SupportTicket::where('status', 'resolved')->count(),
            'total'       => SupportTicket::count(),
        ];

        return view('investment.admin.support', compact('tickets', 'stats'));
    }

    /**
     * Assigner un ticket à soi-même.
     */
    public function assign(SupportTicket $ticket)
    {
        $ticket->update([
            'assigned_to' => Auth::id(),
            'status'      => 'in_progress',
        ]);

        return back()->with('success', 'Ticket assigné à vous.');
    }

    /**
     * Changer le statut d'un ticket.
     */
    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
        }

        $ticket->update($data);

        return back()->with('success', 'Statut mis à jour.');
    }
}
