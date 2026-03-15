@extends('layouts.profil')

@section('content')

<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Portefeuilles du Club</h1>
        <p class="page-header-text">Gérez les portefeuilles centraux (trésorerie, seed phrases).</p>
      </div>
      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ route('admin.wallets.create') }}">
          <i class="bi-plus-lg me-1"></i> Ajouter un portefeuille
        </a>
      </div>
    </div>
  </div>

  <div class="row">
    @forelse($wallets as $wallet)
    <div class="col-md-6 col-lg-4 mb-3 mb-lg-5">
      <div class="card h-100">
        <div class="card-header card-header-content-between">
          <div>
            <h4 class="card-header-title">{{ $wallet->name }}</h4>
            <span class="badge bg-soft-primary text-primary">{{ $wallet->network ?? 'N/A' }}</span>
          </div>
          <div class="dropdown">
            <button class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
              <i class="bi-three-dots-vertical"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
              <a class="dropdown-item" href="{{ route('admin.wallets.edit', $wallet->id) }}"><i class="bi-pencil dropdown-item-icon"></i> Modifier</a>
              <div class="dropdown-divider"></div>
              <form action="{{ route('admin.wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('Supprimer ce portefeuille ?');">
                @csrf @method('DELETE')
                <button class="dropdown-item text-danger"><i class="bi-trash dropdown-item-icon"></i> Supprimer</button>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <small class="text-cap">Adresse Publique</small>
            <div class="bg-light rounded p-2" style="font-family: monospace; font-size: 12px; word-break: break-all;">
              {{ $wallet->address ?? 'Non définie' }}
            </div>
          </div>

          @if($wallet->recovery_phrase)
          <div class="mb-3">
            <small class="text-cap text-danger"><i class="bi-exclamation-triangle me-1"></i>Seed Phrase</small>
            <div class="bg-soft-danger rounded p-2" style="filter: blur(5px); transition: filter 0.3s; cursor: pointer; font-family: monospace; font-size: 12px; word-break: break-word;" onmouseover="this.style.filter='blur(0)'" onmouseout="this.style.filter='blur(5px)'">
              {{ $wallet->recovery_phrase }}
            </div>
          </div>
          @endif

          @if($wallet->private_key)
          <div class="mb-3">
            <small class="text-cap text-danger"><i class="bi-key me-1"></i>Clé Privée</small>
            <div class="bg-soft-danger rounded p-2" style="filter: blur(5px); transition: filter 0.3s; cursor: pointer; font-family: monospace; font-size: 12px; word-break: break-all;" onmouseover="this.style.filter='blur(0)'" onmouseout="this.style.filter='blur(5px)'">
              {{ $wallet->private_key }}
            </div>
          </div>
          @endif

          @if($wallet->notes)
          <div class="border-top pt-3 mt-3">
            <small class="text-muted"><i class="bi-sticky me-1"></i>{{ $wallet->notes }}</small>
          </div>
          @endif
        </div>
      </div>
    </div>
    @empty
    <div class="col-12">
      <div class="card text-center py-5">
        <div class="card-body">
          <i class="bi-wallet2" style="font-size: 3rem; color: #bdc5d1;"></i>
          <h4 class="mt-3">Aucun portefeuille configuré</h4>
          <p class="text-muted">Ajoutez les portefeuilles centraux du club pour sécuriser les seed phrases.</p>
          <a href="{{ route('admin.wallets.create') }}" class="btn btn-primary mt-2">Ajouter un portefeuille</a>
        </div>
      </div>
    </div>
    @endforelse
  </div>
</div>

@endsection
