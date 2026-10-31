<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Department;
use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('admission_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('semester')) {
            $query->where('current_semester', $request->semester);
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('students.index', compact('students', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        // Generate recommended admission number
        $nextId = (Student::max('id') ?? 0) + 1;
        $recommendedRoll = 'STU' . date('y') . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('students.create', compact('departments', 'recommendedRoll'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_number' => 'required|string|max:50|unique:students,admission_number',
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:students,email',
            'phone' => 'nullable|string|max:30',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:30',
            'enrollment_date' => 'required|date',
            'current_semester' => 'required|integer|min:1|max:12',
            'status' => 'required|in:Active,Inactive,Graduated,Suspended',
        ]);

        $student = Student::create($validated);

        // Auto-enroll student into department's semester courses if available
        $courses = Course::where('department_id', $student->department_id)
                         ->where('semester', $student->current_semester)
                         ->get();

        foreach ($courses as $course) {
            Enrollment::firstOrCreate([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'academic_year' => '2026-2027',
                'semester' => 'Semester ' . $student->current_semester,
            ], [
                'enrollment_date' => $student->enrollment_date,
                'status' => 'Enrolled',
            ]);
        }

        return redirect()->route('students.show', $student->id)
                         ->with('success', 'Student ' . $student->full_name . ' registered successfully!');
    }

    public function show($id)
    {
        $student = Student::with([
            'department',
            'courses.department',
            'grades.course',
            'attendances.course',
            'feeInvoices' => function ($q) {
                $q->latest();
            }
        ])->findOrFail($id);

        $availableCourses = Course::where('department_id', $student->department_id)
                                  ->whereNotIn('id', $student->courses->pluck('id'))
                                  ->get();

        // Calculate statistics
        $attendanceTotal = $student->attendances->count();
        $attendancePresent = $student->attendances->whereIn('status', ['Present', 'Late'])->count();
        $attendanceRate = $attendanceTotal > 0 ? round(($attendancePresent / $attendanceTotal) * 100, 1) : 96.0;

        $gpa = $student->gpa;
        $totalCredits = $student->courses->sum('credits');

        return view('students.show', compact('student', 'availableCourses', 'attendanceTotal', 'attendancePresent', 'attendanceRate', 'gpa', 'totalCredits'));
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $departments = Department::orderBy('name')->get();

        return view('students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'admission_number' => 'required|string|max:50|unique:students,admission_number,' . $student->id,
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:30',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:30',
            'enrollment_date' => 'required|date',
            'current_semester' => 'required|integer|min:1|max:12',
            'status' => 'required|in:Active,Inactive,Graduated,Suspended',
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student->id)
                         ->with('success', 'Student details updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $name = $student->full_name;
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', "Student {$name} removed successfully.");
    }

    public function idCard($id)
    {
        $student = Student::with('department')->findOrFail($id);
        return view('students.id_card', compact('student'));
    }

    public function enrollCourse(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string',
        ]);

        Enrollment::firstOrCreate([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'academic_year' => '2026-2027',
            'semester' => $request->semester,
        ], [
            'enrollment_date' => Carbon::now()->toDateString(),
            'status' => 'Enrolled',
        ]);

        return redirect()->route('students.show', $student->id)
                         ->with('success', 'Student successfully enrolled in course.');
    }
}
