@extends('layouts.profil')

@section('content')
<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">{{ $course->title }}</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <p><strong>Description :</strong> {{ $course->description }}</p>
                <p><strong>Créateur :</strong> {{ $course->creator->name ?? 'Non spécifié' }}</p>
                <p>
                    <strong>Premium :</strong>
                    <span class="badge {{ $course->is_premium ? 'bg-success' : 'bg-secondary' }}">
                        {{ $course->is_premium ? 'Oui' : 'Non' }}
                    </span>
                </p>

                @if($course->cover)
                <p><strong>Image de Couverture :</strong></p>
                <img src="{{ asset('storage/' . $course->cover) }}" alt="Couverture" width="200">
                @endif

                @if($course->media->count() > 0)
                <p><strong>Médias Associés :</strong></p>
                <ul>
                    @foreach($course->media as $media)
                    <li>
                        <a href="{{ asset('storage/' . $media->media_path) }}" target="_blank">Voir Média</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
