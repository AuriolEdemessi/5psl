@extends('layouts.profil')

@section('content')
<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Liste des Cours</h1>
                </div>
                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="{{ route('courses.create') }}">
                        <i class="bi-plus-lg me-1"></i> Ajouter un Cours
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-header-title">Tous les cours</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Créateur</th>
                            <th>Premium</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->creator->name ?? 'Non spécifié' }}</td>
                            <td>
                                <span class="badge {{ $course->is_premium ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $course->is_premium ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi-eye"></i>
                                </a>
                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi-pencil"></i>
                                </a>
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">
                                        <i class="bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
