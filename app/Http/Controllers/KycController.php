<?php

namespace App\Http\Controllers;

use App\Models\KycDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $documents = $user->kycDocuments()->orderBy('created_at', 'desc')->get();
        return view('kyc.index', compact('user', 'documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|in:id_card,passport,driver_license',
            'document_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        $user = Auth::user();

        // Si KYC déjà validé, on refuse de soumettre un nouveau document
        if ($user->kyc_status === 'verified') {
            return redirect()->back()->with('error', 'Votre KYC est déjà validé.');
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            // Store file securely
            $path = $file->store('kyc_documents', 'local');

            KycDocument::create([
                'user_id' => $user->id,
                'document_type' => $request->document_type,
                'file_path' => $path,
            ]);

            // Mettre à jour le statut du user
            $user->kyc_status = 'pending';
            $user->save();

            return redirect()->back()->with('success', 'Document soumis avec succès. Notre équipe va l\'examiner.');
        }

        return redirect()->back()->with('error', 'Erreur lors du téléchargement du fichier.');
    }
}
