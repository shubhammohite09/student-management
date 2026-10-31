@extends('layouts.app')

@section('title', 'Academic Courses')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Courses & Curriculum</h1>
            <p class="text-sm text-slate-500 mt-1">Manage departmental subjects, credit allocations, and faculty assignments.</p>
        </div>
        <a href="{{ route('courses.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30 self-start sm:self-auto">
            <span>➕ Create New Course</span>
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('courses.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Search Course</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Code, title, instructor..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Department</label>
                <select name="department_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }} ({{ $dept->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Semester</label>
                <select name="semester" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    <option value="">All Semesters</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-3 rounded-xl transition shadow-sm">
                    Filter
                </button>
                <a href="{{ route('courses.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold py-2 px-3 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Course Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($courses as $course)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-mono text-xs font-extrabold px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700">
                            {{ $course->course_code }}
                        </span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                            {{ $course->credits }} Credits
                        </span>
                    </div>

                    <h3 class="font-display font-bold text-slate-900 text-base leading-snug">
                        <a href="{{ route('courses.show', $course->id) }}" class="hover:text-indigo-600">
                            {{ $course->course_name }}
                        </a>
                    </h3>

                    <p class="text-xs text-slate-500 line-clamp-2 mt-2">
                        {{ $course->description ?? 'Core syllabus curriculum modules.' }}
                    </p>
                </div>

                <div class="space-y-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Department:</span>
                        <span class="font-semibold text-slate-800">{{ $course->department?->code }} (Sem {{ $course->semester }})</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Instructor:</span>
                        <span class="font-semibold text-slate-800">{{ $course->instructor_name ?? 'Faculty Staff' }}</span>
                    </div>

                    <!-- Enrollment capacity bar -->
                    <div>
                        <div class="flex justify-between text-[11px] mb-1">
                            <span class="text-slate-400">Enrollment</span>
                            <span class="font-bold text-indigo-600">{{ $course->students_count }} / {{ $course->capacity }} enrolled</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden">
                            @php
                                $fill = min(100, round(($course->students_count / max(1, $course->capacity)) * 100));
                            @endphp
                            <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $fill }}%"></div>
                        </div>
                    </div>

                    <div class="pt-2 flex items-center justify-between">
                        <a href="{{ route('courses.show', $course->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs">
                            View Students →
                        </a>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('courses.edit', $course->id) }}" class="p-1 rounded text-slate-400 hover:text-amber-600">✏️</a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete course {{ $course->course_name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 rounded text-slate-400 hover:text-rose-600">🗑️</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 bg-white rounded-2xl border border-slate-200">
                <div class="text-3xl mb-2">📚</div>
                <div class="text-sm font-semibold">No courses found</div>
                <div class="text-xs text-slate-400">Try adjusting filters or create a new course.</div>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-sm">
            {{ $courses->links() }}
        </div>
    @endif

</div>
@endsection
