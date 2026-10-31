@extends('layouts.app')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Greeting Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                Good Morning, John! <span class="text-2xl">👋</span>
            </h1>
            <p class="text-sm text-slate-500 mt-1">Here is the executive overview of your campus operations today.</p>
        </div>
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold self-start sm:self-auto">
            <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
            <span>Live Campus System Active</span>
        </div>
    </div>

    <!-- 4 Key Performance Indicator (KPI) Metric Cards (Matches Canva Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Students -->
        <div class="bg-gradient-to-br from-indigo-900 to-indigo-800 text-white rounded-2xl p-5 shadow-lg shadow-indigo-900/20 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Total Students</span>
                <span class="p-2 rounded-xl bg-white/10 text-white text-sm">👥</span>
            </div>
            <div class="text-3xl md:text-4xl font-display font-extrabold tracking-tight">{{ number_format($totalStudents) }}</div>
            <div class="flex items-center gap-1.5 text-xs text-indigo-200 mt-3 font-medium">
                <span class="inline-flex items-center text-emerald-300 font-bold">↑ +5.2%</span>
                <span>from last semester</span>
            </div>
        </div>

        <!-- Card 2: Active Courses -->
        <div class="bg-gradient-to-br from-teal-800 to-teal-700 text-white rounded-2xl p-5 shadow-lg shadow-teal-900/20 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-teal-200 uppercase tracking-wider">Active Courses</span>
                <span class="p-2 rounded-xl bg-white/10 text-white text-sm">📚</span>
            </div>
            <div class="text-3xl md:text-4xl font-display font-extrabold tracking-tight">{{ number_format($totalCourses) }}</div>
            <div class="flex items-center gap-1.5 text-xs text-teal-200 mt-3 font-medium">
                <span class="text-white font-bold">+3</span>
                <span>new departments added</span>
            </div>
        </div>

        <!-- Card 3: Fees Collected -->
        <div class="bg-gradient-to-br from-amber-600 to-amber-700 text-white rounded-2xl p-5 shadow-lg shadow-amber-900/20 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-amber-200 uppercase tracking-wider">Fees Collected</span>
                <span class="p-2 rounded-xl bg-white/10 text-white text-sm">💳</span>
            </div>
            <div class="text-3xl md:text-4xl font-display font-extrabold tracking-tight">${{ number_format($totalFeesCollected, 2) }}</div>
            <div class="flex items-center gap-1.5 text-xs text-amber-100 mt-3 font-medium">
                <span class="text-white font-bold">{{ $feeCollectionRate }}%</span>
                <span>of semester target</span>
            </div>
        </div>

        <!-- Card 4: Today's Attendance -->
        <div class="bg-gradient-to-br from-emerald-700 to-emerald-800 text-white rounded-2xl p-5 shadow-lg shadow-emerald-900/20 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition"></div>
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-emerald-200 uppercase tracking-wider">Today's Attendance</span>
                <span class="p-2 rounded-xl bg-white/10 text-white text-sm">✅</span>
            </div>
            <div class="text-3xl md:text-4xl font-display font-extrabold tracking-tight">{{ $todayAttendanceRate }}%</div>
            <div class="flex items-center gap-1.5 text-xs text-emerald-100 mt-3 font-medium">
                <span class="text-white font-bold">Optimal</span>
                <span>attendance rate</span>
            </div>
        </div>
    </div>

    <!-- Main Grid: Enrollment Trends Chart & Recent Registrations Table -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Student Enrollment Trends (Canva Chart Replica) -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-display font-bold text-slate-800 text-base">Student Enrollment Trends</h3>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600">Year 2026</span>
                </div>
                <p class="text-xs text-slate-500 mb-6">Monthly new enrollments across all academic departments.</p>

                <!-- Responsive CSS/HTML Bar Chart (Matching Canva Mockup) -->
                <div class="h-48 flex items-end justify-between gap-4 pt-6 px-2 border-b border-slate-100 pb-2">
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <span class="text-xs font-bold text-slate-500 group-hover:text-teal-600 transition">180</span>
                        <div class="w-full bg-teal-400/60 hover:bg-teal-500 rounded-t-xl transition-all h-24 shadow-sm"></div>
                        <span class="text-xs text-slate-500 font-semibold">Jul</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <span class="text-xs font-bold text-slate-500 group-hover:text-teal-600 transition">210</span>
                        <div class="w-full bg-teal-400/75 hover:bg-teal-500 rounded-t-xl transition-all h-32 shadow-sm"></div>
                        <span class="text-xs text-slate-500 font-semibold">Aug</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <span class="text-xs font-bold text-slate-500 group-hover:text-teal-600 transition">260</span>
                        <div class="w-full bg-teal-500/90 hover:bg-teal-600 rounded-t-xl transition-all h-40 shadow-sm"></div>
                        <span class="text-xs text-slate-500 font-semibold">Sep</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2 group">
                        <span class="text-xs font-extrabold text-teal-700">290</span>
                        <div class="w-full bg-teal-600 rounded-t-xl shadow-md shadow-teal-600/30 transition-all h-48"></div>
                        <span class="text-xs text-teal-800 font-bold">Oct</span>
                    </div>
                </div>
            </div>

            <!-- Department breakdown footer pills -->
            <div class="pt-4 grid grid-cols-2 gap-2 text-xs">
                @foreach($departments as $dept)
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="font-medium text-slate-700 truncate">{{ $dept->code }}</span>
                        <span class="font-bold text-indigo-600">{{ $dept->students_count }} std</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Recent Registrations Table (Matching Canva Mockup) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-display font-bold text-slate-800 text-base">Recent Registrations</h3>
                    <p class="text-xs text-slate-500">Newly registered students and active status</p>
                </div>
                <a href="{{ route('students.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                    <span>View All</span> <span>→</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-400 uppercase tracking-wider border-b border-slate-200 pb-2">
                            <th class="py-3 font-semibold">Student Name</th>
                            <th class="py-3 font-semibold">Roll No.</th>
                            <th class="py-3 font-semibold">Department</th>
                            <th class="py-3 font-semibold">Status</th>
                            <th class="py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($recentStudents as $student)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-purple-600 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900">{{ $student->full_name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $student->email }}</div>
                                    </div>
                                </td>
                                <td class="py-3.5 font-mono text-slate-600 font-medium">{{ $student->admission_number }}</td>
                                <td class="py-3.5 font-medium text-slate-600">
                                    {{ $student->department?->code ?? 'N/A' }} (Sem {{ $student->current_semester }})
                                </td>
                                <td class="py-3.5">
                                    @if($student->status === 'Active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            {{ $student->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right space-x-2">
                                    <a href="{{ route('students.show', $student->id) }}" class="text-slate-400 hover:text-indigo-600 p-1 transition" title="View Profile">
                                        👁️
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}" class="text-slate-400 hover:text-indigo-600 p-1 transition" title="Edit Student">
                                        ✏️
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">No student records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
        <h3 class="font-display font-bold text-slate-800 text-base mb-4">Quick Operations</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
            <a href="{{ route('students.create') }}" class="p-4 rounded-xl bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 border border-slate-200 transition group flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-110 transition">➕</span>
                <span class="text-xs font-bold text-slate-700 group-hover:text-indigo-700">Add New Student</span>
            </a>

            <a href="{{ route('attendance.index') }}" class="p-4 rounded-xl bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 border border-slate-200 transition group flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-110 transition">📅</span>
                <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700">Daily Attendance</span>
            </a>

            <a href="{{ route('fees.index') }}" class="p-4 rounded-xl bg-slate-50 hover:bg-amber-50 hover:border-amber-200 border border-slate-200 transition group flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-amber-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-110 transition">💵</span>
                <span class="text-xs font-bold text-slate-700 group-hover:text-amber-700">Fees & Invoices</span>
            </a>

            <a href="{{ route('grades.index') }}" class="p-4 rounded-xl bg-slate-50 hover:bg-teal-50 hover:border-teal-200 border border-slate-200 transition group flex flex-col items-center gap-2">
                <span class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center text-lg shadow-sm group-hover:scale-110 transition">📝</span>
                <span class="text-xs font-bold text-slate-700 group-hover:text-teal-700">Record Exam Grades</span>
            </a>
        </div>
    </div>

</div>
@endsection
