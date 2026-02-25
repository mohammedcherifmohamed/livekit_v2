<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollment';

    protected $fillable = [
        'student_id',
        'category_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}