@extends('layouts.app')

@section('title', 'Examination & Grades')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Examinations & Gradebook</h1>
            <p class="text-sm text-slate-500 mt-1">Record assessment marks, view semester scores, and track student GPAs.</p>
        </div>
        <button onclick="document.getElementById('modal-grade-entry').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30 self-start sm:self-auto">
            <span>➕ Record New Grade</span>
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('grades.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Filter by Course</label>
                <select name="course_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->course_code }} - {{ $c->course_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Assessment Type</label>
                <select name="exam_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    <option value="">All Types</option>
                    <option value="Final Examination" {{ request('exam_type') == 'Final Examination' ? 'selected' : '' }}>Final Examination</option>
                    <option value="Midterm Examination" {{ request('exam_type') == 'Midterm Examination' ? 'selected' : '' }}>Midterm Examination</option>
                    <option value="Assignment Portfolio" {{ request('exam_type') == 'Assignment Portfolio' ? 'selected' : '' }}>Assignment Portfolio</option>
                    <option value="Class Quiz" {{ request('exam_type') == 'Class Quiz' ? 'selected' : '' }}>Class Quiz</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-3 rounded-xl transition shadow-sm">
                    Apply Filter
                </button>
                <a href="{{ route('grades.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold py-2 px-3 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Grade Records Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-display font-bold text-slate-900 text-base">Graded Assessments ({{ $grades->total() }})</h3>
            <span class="text-xs text-slate-400">Scale: 4.00 Max GPA</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Student Name</th>
                        <th class="py-3 px-4 font-semibold">Roll Number</th>
                        <th class="py-3 px-4 font-semibold">Subject / Course</th>
                        <th class="py-3 px-4 font-semibold">Assessment</th>
                        <th class="py-3 px-4 font-semibold">Score</th>
                        <th class="py-3 px-4 font-semibold">Grade</th>
                        <th class="py-3 px-4 font-semibold">GPA Point</th>
                        <th class="py-3 px-4 font-semibold">Remarks</th>
                        <th class="py-3 px-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($grades as $grade)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                <a href="{{ route('students.show', $grade->student_id) }}" class="hover:text-indigo-600">
                                    {{ $grade->student?->full_name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-700">{{ $grade->student?->admission_number }}</td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">
                                <span class="font-mono text-indigo-700 font-bold mr-1">{{ $grade->course?->course_code }}</span>
                                {{ $grade->course?->course_name }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $grade->exam_type }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">
                                {{ number_format($grade->marks_obtained, 1) }} / {{ number_format($grade->total_marks, 0) }}
                                <span class="text-[11px] text-slate-400 font-normal">({{ round(($grade->marks_obtained / max(1, $grade->total_marks)) * 100) }}%)</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md font-extrabold text-xs bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $grade->grade_letter }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-extrabold text-slate-900">{{ number_format($grade->grade_point, 2) }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px] italic">{{ $grade->remarks ?? '—' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this grade record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400">No examination records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($grades->hasPages())
            <div class="pt-4 border-t border-slate-200">
                {{ $grades->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal: Record Grade Entry -->
<div id="modal-grade-entry" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-display font-bold text-slate-900 text-base">Record Assessment Score</h3>
            <button onclick="document.getElementById('modal-grade-entry').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>
        <form action="{{ route('grades.store') }}" method="POST" class="space-y-3">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Select Student *</label>
                <select name="student_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <option value="">Choose Student</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->admission_number }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Select Course *</label>
                <select name="course_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <option value="">Choose Course</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->course_code }} - {{ $c->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Exam / Assessment Type *</label>
                <select name="exam_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <option value="Final Examination">Final Examination</option>
                    <option value="Midterm Examination">Midterm Examination</option>
                    <option value="Assignment Portfolio">Assignment Portfolio</option>
                    <option value="Class Quiz">Class Quiz</option>
                    <option value="Lab Practical">Lab Practical</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Marks Obtained *</label>
                    <input type="number" step="0.1" name="marks_obtained" required placeholder="e.g. 88.5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Total Marks *</label>
                    <input type="number" step="0.1" name="total_marks" value="100" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Faculty Remarks</label>
                <input type="text" name="remarks" placeholder="Optional comments..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t">
                <button type="button" onclick="document.getElementById('modal-grade-entry').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm">Save Grade</button>
            </div>
        </form>
    </div>
</div>
@endsection
