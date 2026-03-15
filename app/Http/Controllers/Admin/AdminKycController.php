<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\KycDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKycController extends Controller
{
    public function index()
    {
        $users = User::whereIn('kyc_status', ['pending', 'rejected', 'verified'])->with('kycDocuments')->get();
        return view('admin.kyc.index', compact('users'));
    }

    public function show(User $user)
    {
        $documents = $user->kycDocuments()->orderBy('created_at', 'desc')->get();
        return view('admin.kyc.show', compact('user', 'documents'));
    }

    public function verify(Request $request, User $user)
    {
        $user->kyc_status = 'verified';
        $user->save();

        return redirect()->route('admin.kyc.index')->with('success', 'Le KYC de l\'utilisateur a été vérifié.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $user->kyc_status = 'rejected';
        $user->save();

        // Optional: Save the reason on the latest document
        $latestDoc = $user->kycDocuments()->latest()->first();
        if ($latestDoc) {
            $latestDoc->rejection_reason = $request->reason;
            $latestDoc->save();
        }

        return redirect()->route('admin.kyc.index')->with('success', 'Le KYC de l\'utilisateur a été rejeté.');
    }

    public function download(KycDocument $document)
    {
        if (Storage::disk('local')->exists($document->file_path)) {
            return Storage::disk('local')->download($document->file_path);
        }
        
        return redirect()->back()->with('error', 'Le fichier n\'existe plus.');
    }
}
