@extends('layouts.profil')

@section('content')
<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Modifier le Cours</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $course->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control" required>{{ $course->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="cover" class="form-label">Image de Couverture</label>
                        <input type="file" name="cover" id="cover" class="form-control">
                        @if($course->cover)
                        <img src="{{ asset('storage/' . $course->cover) }}" alt="Couverture" width="200" class="mt-2">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="is_premium" class="form-label">Premium</label>
                        <select name="is_premium" id="is_premium" class="form-select">
                            <option value="0" {{ !$course->is_premium ? 'selected' : '' }}>Non</option>
                            <option value="1" {{ $course->is_premium ? 'selected' : '' }}>Oui</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
