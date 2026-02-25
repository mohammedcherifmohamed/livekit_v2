<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'category_id',
        'title',
        'description',
        'room_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The user who created/owns this course.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * The category this course belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
