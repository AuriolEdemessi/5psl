<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Afficher la liste des cours.
     */
    public function index()
    {
        $courses = Course::with('creator', 'media')->get();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Afficher le formulaire de création d'un cours.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Enregistrer un nouveau cours.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240', // Images ou vidéos
        ]);

        // Gestion de l'image de couverture
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        // Création du cours
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_premium' => $request->boolean('is_premium'),
            'cover' => $coverPath,
            'created_by' => Auth::id(),
        ]);

        // Gestion des médias associés
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $media) {
                $mediaPath = $media->store('course_media', 'public');
                CourseMedia::create([
                    'course_id' => $course->id,
                    'media_path' => $mediaPath,
                    'media_type' => $media->getMimeType(),
                ]);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Cours créé avec succès !');
    }

    /**
     * Afficher les détails d'un cours.
     */
    public function show($id)
    {
        $course = Course::with('media', 'creator')->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Afficher le formulaire de modification d'un cours.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Mettre à jour un cours existant.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Mise à jour de l'image de couverture
        if ($request->hasFile('cover')) {
            if ($course->cover) {
                Storage::disk('public')->delete($course->cover);
            }
            $course->cover = $request->file('cover')->store('covers', 'public');
        }

        // Mise à jour des informations du cours
        $course->update($request->only(['title', 'description', 'is_premium']));

        return redirect()->route('courses.index')->with('success', 'Cours mis à jour avec succès !');
    }

    /**
     * Supprimer un cours existant.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // Supprimer l'image de couverture
        if ($course->cover) {
            Storage::disk('public')->delete($course->cover);
        }

        // Supprimer les médias associés
        foreach ($course->media as $media) {
            Storage::disk('public')->delete($media->media_path);
            $media->delete();
        }

        // Supprimer le cours
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Cours supprimé avec succès !');
    }
}
