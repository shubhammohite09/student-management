@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Daily Attendance Register</h1>
            <p class="text-sm text-slate-500 mt-1">Track classroom participation, log absences, and generate attendance records.</p>
        </div>
    </div>

    <!-- Course & Date Selection Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('attendance.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Select Course *</label>
                <select name="course_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 font-medium focus:outline-none focus:border-indigo-500">
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ $selectedCourseId == $c->id ? 'selected' : '' }}>
                            {{ $c->course_code }} - {{ $c->course_name }} ({{ $c->department?->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Register Date *</label>
                <input type="date" name="date" value="{{ $selectedDate }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-medium focus:outline-none focus:border-indigo-500">
            </div>

            <div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-md shadow-indigo-600/30">
                    Load Class Register
                </button>
            </div>
        </form>
    </div>

    @if($course)
        <!-- Attendance Session Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm text-center">
                <span class="text-xs text-slate-400 font-bold uppercase">Enrolled Students</span>
                <div class="text-2xl font-display font-extrabold text-slate-800 mt-1">{{ $students->count() }}</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm text-center">
                <span class="text-xs text-emerald-600 font-bold uppercase">Present Marked</span>
                <div class="text-2xl font-display font-extrabold text-emerald-600 mt-1">{{ $presentCount }}</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm text-center">
                <span class="text-xs text-rose-500 font-bold uppercase">Absent Marked</span>
                <div class="text-2xl font-display font-extrabold text-rose-600 mt-1">{{ $absentCount }}</div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm text-center">
                <span class="text-xs text-indigo-600 font-bold uppercase">Attendance Rate</span>
                <div class="text-2xl font-display font-extrabold text-indigo-700 mt-1">{{ $rate }}%</div>
            </div>
        </div>

        <!-- Attendance Marking Table -->
        <form action="{{ route('attendance.store') }}" method="POST" class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 space-y-4">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="date" value="{{ $selectedDate }}">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-3">
                <div>
                    <h3 class="font-display font-bold text-slate-900 text-base">Class Roster: {{ $course->course_name }}</h3>
                    <p class="text-xs text-slate-500">Date: {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" onclick="markAll('Present')" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold transition">
                        ✓ Mark All Present
                    </button>
                    <button type="button" onclick="markAll('Absent')" class="px-3 py-1.5 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 text-xs font-bold transition">
                        ✗ Mark All Absent
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Student Name</th>
                            <th class="py-3 px-4 font-semibold">Roll Number</th>
                            <th class="py-3 px-6 font-semibold text-center">Status</th>
                            <th class="py-3 px-4 font-semibold">Notes / Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $student)
                            @php
                                $rec = $existingRecords->get($student->id);
                                $currentStatus = $rec ? $rec->status : 'Present';
                                $currentRemarks = $rec ? $rec->remarks : '';
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3.5 px-4 font-semibold text-slate-900 flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </div>
                                    <a href="{{ route('students.show', $student->id) }}" class="hover:text-indigo-600">
                                        {{ $student->full_name }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-slate-700">{{ $student->admission_number }}</td>
                                <td class="py-3.5 px-6">
                                    <div class="flex items-center justify-center gap-3">
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Present" {{ $currentStatus === 'Present' ? 'checked' : '' }} class="status-radio-present text-emerald-600 focus:ring-emerald-500">
                                            <span class="text-xs font-bold text-emerald-700">Present</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Late" {{ $currentStatus === 'Late' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                                            <span class="text-xs font-bold text-amber-600">Late</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Absent" {{ $currentStatus === 'Absent' ? 'checked' : '' }} class="status-radio-absent text-rose-600 focus:ring-rose-500">
                                            <span class="text-xs font-bold text-rose-600">Absent</span>
                                        </label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="Excused" {{ $currentStatus === 'Excused' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500">
                                            <span class="text-xs font-bold text-blue-600">Excused</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <input type="text" name="remarks[{{ $student->id }}]" value="{{ $currentRemarks }}" placeholder="Optional notes..." class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1 text-xs text-slate-700 focus:outline-none focus:border-indigo-500">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">No students enrolled in this course.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->isNotEmpty())
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/30 transition">
                        💾 Save Attendance Register
                    </button>
                </div>
            @endif
        </form>
    @endif

</div>

<script>
    function markAll(status) {
        if (status === 'Present') {
            document.querySelectorAll('.status-radio-present').forEach(r => r.checked = true);
        } else if (status === 'Absent') {
            document.querySelectorAll('.status-radio-absent').forEach(r => r.checked = true);
        }
    }
</script>
@endsection
