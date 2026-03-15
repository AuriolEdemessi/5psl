<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClubWallet;
use Illuminate\Http\Request;

class ClubWalletController extends Controller
{
    public function index()
    {
        $wallets = ClubWallet::orderBy('created_at', 'desc')->get();
        return view('admin.wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('admin.wallets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'network' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'recovery_phrase' => 'nullable|string',
            'private_key' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        ClubWallet::create($request->all());

        return redirect()->route('admin.wallets.index')->with('success', 'Portefeuille ajouté avec succès.');
    }

    public function edit(ClubWallet $wallet)
    {
        return view('admin.wallets.edit', compact('wallet'));
    }

    public function update(Request $request, ClubWallet $wallet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'network' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'recovery_phrase' => 'nullable|string',
            'private_key' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $wallet->update($request->all());

        return redirect()->route('admin.wallets.index')->with('success', 'Portefeuille mis à jour avec succès.');
    }

    public function destroy(ClubWallet $wallet)
    {
        $wallet->delete();
        return redirect()->route('admin.wallets.index')->with('success', 'Portefeuille supprimé avec succès.');
    }
}
