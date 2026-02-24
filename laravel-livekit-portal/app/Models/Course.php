<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The category this course belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
