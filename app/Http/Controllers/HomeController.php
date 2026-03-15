<?php

namespace App\Http\Controllers;

use App\Services\InvestmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected InvestmentService $investmentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvestmentService $investmentService)
    {
        $this->middleware('auth');
        $this->investmentService = $investmentService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $balance        = $this->investmentService->getUserBalance($user);
        $portfolioValue = $this->investmentService->getUserPortfolioValue($user);
        $roi            = $this->investmentService->getUserROI($user);
        $tier           = $user->tier ?? 'STARTER';

        $recentTransactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('home', compact('balance', 'portfolioValue', 'roi', 'tier', 'recentTransactions'));
    }
}
