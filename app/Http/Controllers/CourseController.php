<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Department;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('department')->withCount('students');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%")
                  ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $courses = $query->orderBy('course_code')->paginate(12)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('courses.index', compact('courses', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'course_code' => 'required|string|max:20|unique:courses,course_code',
            'course_name' => 'required|string|max:150',
            'credits' => 'required|integer|min:1|max:10',
            'semester' => 'required|integer|min:1|max:12',
            'instructor_name' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:5|max:200',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($validated);

        return redirect()->route('courses.index')
                         ->with('success', "Course {$course->course_code} - {$course->course_name} created successfully!");
    }

    public function show($id)
    {
        $course = Course::with(['department', 'students.department', 'grades.student'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        return view('courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:150',
            'credits' => 'required|integer|min:1|max:10',
            'semester' => 'required|integer|min:1|max:12',
            'instructor_name' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:5|max:200',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
                         ->with('success', "Course {$course->course_code} updated successfully!");
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $name = $course->course_name;
        $course->delete();

        return redirect()->route('courses.index')
                         ->with('success', "Course {$name} removed successfully.");
    }
}
