<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'completed',
    ];
}