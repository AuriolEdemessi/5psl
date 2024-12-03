<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Colonnes autorisées pour l'insertion ou la mise à jour
    protected $fillable = [
        'title',
        'description',
        'is_premium',
        'cover',
        'created_by',
    ];

    /**
     * Relation avec les médias associés (hasMany)
     */
    public function media()
    {
        return $this->hasMany(CourseMedia::class);
    }

    /**
     * Relation avec l'utilisateur créateur (belongsTo)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
