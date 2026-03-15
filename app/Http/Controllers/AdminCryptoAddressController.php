<?php

namespace App\Http\Controllers;

use App\Models\CryptoAddress;
use Illuminate\Http\Request;

class AdminCryptoAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isAdmin']);
    }

    /**
     * Liste toutes les adresses crypto.
     */
    public function index()
    {
        $addresses = CryptoAddress::orderBy('coin')->orderBy('network')->get();
        $grouped   = $addresses->groupBy('coin');

        return view('investment.admin.crypto-addresses', compact('addresses', 'grouped'));
    }

    /**
     * Enregistre une nouvelle adresse.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coin'    => 'required|string|max:10',
            'network' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'label'   => 'nullable|string|max:100',
        ]);

        CryptoAddress::create([
            'coin'      => strtoupper($request->coin),
            'network'   => $request->network,
            'address'   => trim($request->address),
            'label'     => $request->label,
            'is_active' => true,
        ]);

        return back()->with('success', 'Adresse crypto ajoutée avec succès.');
    }

    /**
     * Met à jour une adresse existante.
     */
    public function update(Request $request, CryptoAddress $cryptoAddress)
    {
        $request->validate([
            'coin'    => 'required|string|max:10',
            'network' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'label'   => 'nullable|string|max:100',
        ]);

        $cryptoAddress->update([
            'coin'    => strtoupper($request->coin),
            'network' => $request->network,
            'address' => trim($request->address),
            'label'   => $request->label,
        ]);

        return back()->with('success', 'Adresse mise à jour.');
    }

    /**
     * Active/désactive une adresse.
     */
    public function toggleActive(CryptoAddress $cryptoAddress)
    {
        $cryptoAddress->update(['is_active' => !$cryptoAddress->is_active]);

        return back()->with('success', 'Statut mis à jour.');
    }

    /**
     * Supprime une adresse.
     */
    public function destroy(CryptoAddress $cryptoAddress)
    {
        $cryptoAddress->delete();

        return back()->with('success', 'Adresse supprimée.');
    }
}
