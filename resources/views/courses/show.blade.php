@extends('layouts.app')

@section('title', 'Course: ' . $course->course_name)

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('courses.index') }}" class="hover:text-indigo-600">Courses</a>
                <span>›</span>
                <span class="text-slate-800 font-semibold">{{ $course->course_code }}</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-slate-900 tracking-tight">{{ $course->course_name }}</h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('courses.edit', $course->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                ✏️ Edit Course
            </a>
            <a href="{{ route('courses.index') }}" class="px-4 py-2 rounded-xl bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-xs font-bold transition">
                ← All Courses
            </a>
        </div>
    </div>

    <!-- Course Overview Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-1">Course Code</span>
            <span class="font-mono text-xl font-extrabold text-indigo-700">{{ $course->course_code }}</span>
        </div>

        <div>
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-1">Department</span>
            <span class="font-bold text-slate-800 text-sm">{{ $course->department?->name }} ({{ $course->department?->code }})</span>
        </div>

        <div>
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-1">Instructor</span>
            <span class="font-bold text-slate-800 text-sm">{{ $course->instructor_name ?? 'Faculty Staff' }}</span>
        </div>

        <div>
            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block mb-1">Credits & Capacity</span>
            <span class="font-bold text-slate-800 text-sm">{{ $course->credits }} Credits • {{ $course->students->count() }}/{{ $course->capacity }} Enrolled</span>
        </div>
    </div>

    <!-- Enrolled Students Roster -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="font-display font-bold text-slate-900 text-base">Enrolled Students ({{ $course->students->count() }})</h3>
                <p class="text-xs text-slate-500">Students officially registered for this academic term</p>
            </div>
            <a href="{{ route('attendance.index', ['course_id' => $course->id]) }}" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                Take Course Attendance
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Student</th>
                        <th class="py-3 px-4 font-semibold">Roll Number</th>
                        <th class="py-3 px-4 font-semibold">Department</th>
                        <th class="py-3 px-4 font-semibold">Email</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 text-right font-semibold">Profile</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($course->students as $student)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                </div>
                                <span class="font-semibold text-slate-900">{{ $student->full_name }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">{{ $student->admission_number }}</td>
                            <td class="py-3.5 px-4 font-medium">{{ $student->department?->code }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $student->email }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('students.show', $student->id) }}" class="text-indigo-600 hover:underline font-bold">View →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">No students currently enrolled in this course.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
