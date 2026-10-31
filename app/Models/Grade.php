<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'exam_type',
        'marks_obtained',
        'total_marks',
        'grade_letter',
        'grade_point',
        'remarks',
    ];

    protected $casts = [
        'marks_obtained' => 'float',
        'total_marks' => 'float',
        'grade_point' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
