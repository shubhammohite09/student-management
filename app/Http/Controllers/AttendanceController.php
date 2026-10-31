<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('course_code')->get();
        $selectedCourseId = $request->get('course_id', $courses->first()?->id);
        $selectedDate = $request->get('date', Carbon::today()->toDateString());

        $course = null;
        $students = collect();
        $existingRecords = collect();

        if ($selectedCourseId) {
            $course = Course::with('students')->find($selectedCourseId);
            if ($course) {
                $students = $course->students;
                $existingRecords = Attendance::where('course_id', $selectedCourseId)
                                             ->where('date', $selectedDate)
                                             ->get()
                                             ->keyBy('student_id');
            }
        }

        // Attendance stats for selected course & date
        $totalMarked = $existingRecords->count();
        $presentCount = $existingRecords->whereIn('status', ['Present', 'Late'])->count();
        $absentCount = $existingRecords->where('status', 'Absent')->count();
        $rate = $totalMarked > 0 ? round(($presentCount / $totalMarked) * 100, 1) : 0;

        return view('attendance.index', compact(
            'courses',
            'selectedCourseId',
            'selectedDate',
            'course',
            'students',
            'existingRecords',
            'totalMarked',
            'presentCount',
            'absentCount',
            'rate'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:Present,Absent,Late,Excused',
        ]);

        $courseId = $request->course_id;
        $date = $request->date;

        foreach ($request->attendance as $studentId => $status) {
            $remarks = $request->input("remarks.{$studentId}", null);

            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'date' => $date,
                ],
                [
                    'status' => $status,
                    'remarks' => $remarks,
                ]
            );
        }

        return redirect()->route('attendance.index', [
            'course_id' => $courseId,
            'date' => $date
        ])->with('success', 'Attendance records saved successfully for ' . $date);
    }
}
