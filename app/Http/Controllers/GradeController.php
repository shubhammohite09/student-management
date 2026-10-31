<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Course;
use App\Models\Student;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('course_code')->get();
        $query = Grade::with(['student.department', 'course']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        $grades = $query->latest()->paginate(15)->withQueryString();
        $students = Student::orderBy('first_name')->get();

        return view('grades.index', compact('grades', 'courses', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'exam_type' => 'required|string|max:100',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'total_marks' => 'required|numeric|min:1|max:100',
            'remarks' => 'nullable|string|max:255',
        ]);

        $marks = $validated['marks_obtained'];
        $total = $validated['total_marks'];
        $percentage = ($marks / $total) * 100;

        // Auto calculate letter grade & grade point
        if ($percentage >= 95) {
            $letter = 'A+';
            $points = 4.00;
        } elseif ($percentage >= 90) {
            $letter = 'A';
            $points = 4.00;
        } elseif ($percentage >= 85) {
            $letter = 'A-';
            $points = 3.70;
        } elseif ($percentage >= 80) {
            $letter = 'B+';
            $points = 3.30;
        } elseif ($percentage >= 75) {
            $letter = 'B';
            $points = 3.00;
        } elseif ($percentage >= 70) {
            $letter = 'B-';
            $points = 2.70;
        } elseif ($percentage >= 65) {
            $letter = 'C+';
            $points = 2.30;
        } elseif ($percentage >= 60) {
            $letter = 'C';
            $points = 2.00;
        } elseif ($percentage >= 50) {
            $letter = 'D';
            $points = 1.00;
        } else {
            $letter = 'F';
            $points = 0.00;
        }

        Grade::create([
            'student_id' => $validated['student_id'],
            'course_id' => $validated['course_id'],
            'exam_type' => $validated['exam_type'],
            'marks_obtained' => $marks,
            'total_marks' => $total,
            'grade_letter' => $letter,
            'grade_point' => $points,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()->back()->with('success', "Grade recorded: {$marks}/{$total} ({$letter} - GPA: {$points})");
    }

    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->back()->with('success', 'Grade record deleted.');
    }
}
