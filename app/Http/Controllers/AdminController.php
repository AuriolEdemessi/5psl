<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\GlobalStat;
use App\Models\SupportTicket;
use App\Models\InvestmentOpportunity;
use App\Models\KycDocument;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = GlobalStat::current();

        $totalMembers = User::where('role', 'member')->count();
        $pendingKycCount = User::where('kyc_status', 'pending')->count();
        $verifiedKycCount = User::where('kyc_status', 'verified')->count();

        $pendingTransactions = Transaction::where('statut', 'en_attente')->count();
        $totalDeposits = (float) Transaction::where('type', 'depot')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant');
        $totalWithdrawals = (float) Transaction::where('type', 'retrait')
            ->whereIn('statut', ['approuve', 'valide'])
            ->sum('montant');

        $openTickets = SupportTicket::where('status', '!=', 'closed')->count();
        $activeOpportunities = InvestmentOpportunity::where('statut', 'ouverte')->count();

        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $recentMembers = User::where('role', 'member')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $tierBreakdown = [
            'STARTER' => User::where('role', 'member')->where('tier', 'STARTER')->count(),
            'PRO'     => User::where('role', 'member')->where('tier', 'PRO')->count(),
            'ELITE'   => User::where('role', 'member')->where('tier', 'ELITE')->count(),
        ];

        return view('profil.admin', compact(
            'stats',
            'totalMembers',
            'pendingKycCount',
            'verifiedKycCount',
            'pendingTransactions',
            'totalDeposits',
            'totalWithdrawals',
            'openTickets',
            'activeOpportunities',
            'recentTransactions',
            'recentMembers',
            'tierBreakdown'
        ));
    }
}
