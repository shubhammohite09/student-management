@extends('layouts.app')

@section('title', 'Edit Course: ' . $course->course_code)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('courses.index') }}" class="hover:text-indigo-600">Courses</a>
                <span>›</span>
                <span class="text-slate-800 font-semibold">{{ $course->course_code }}</span>
                <span>›</span>
                <span>Edit</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-slate-900 tracking-tight">Edit Academic Course</h1>
        </div>
        <a href="{{ route('courses.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            ← Back to Courses
        </a>
    </div>

    <form action="{{ route('courses.update', $course->id) }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Department *</label>
                <select name="department_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $course->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }} ({{ $dept->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Course Code *</label>
                <input type="text" name="course_code" value="{{ old('course_code', $course->course_code) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-mono font-bold focus:outline-none focus:border-indigo-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Course Name / Title *</label>
                <input type="text" name="course_name" value="{{ old('course_name', $course->course_name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Credit Units *</label>
                <input type="number" name="credits" value="{{ old('credits', $course->credits) }}" required min="1" max="10" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Semester Level *</label>
                <select name="semester" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ old('semester', $course->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Instructor / Faculty Name</label>
                <input type="text" name="instructor_name" value="{{ old('instructor_name', $course->instructor_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Student Capacity *</label>
                <input type="number" name="capacity" value="{{ old('capacity', $course->capacity) }}" required min="5" max="200" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Curriculum Description</label>
                <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">{{ old('description', $course->description) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <a href="{{ route('courses.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30">
                Update Course
            </button>
        </div>
    </form>

</div>
@endsection
