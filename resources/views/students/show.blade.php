@extends('layouts.app')

@section('title', 'Student Profile: ' . $student->full_name)

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Actions Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('students.index') }}" class="hover:text-indigo-600">Students</a>
                <span>›</span>
                <span class="text-slate-800 font-semibold">{{ $student->full_name }}</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-slate-900 tracking-tight">Student Profile: {{ $student->full_name }}</h1>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('students.id_card', $student->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                <span>🪪 Print ID Card</span>
            </a>
            <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold transition border border-indigo-200">
                <span>✏️ Edit Profile</span>
            </a>
        </div>
    </div>

    <!-- Canva Mockup Replica Hero Card -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Hero Profile Details (8 Cols) -->
        <div class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row items-center sm:items-start gap-6">
            <!-- Avatar -->
            <div class="w-28 h-28 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-violet-700 border-4 border-indigo-100 flex items-center justify-center text-white text-3xl font-display font-extrabold shadow-lg shadow-indigo-600/30 flex-shrink-0">
                {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
            </div>

            <!-- Profile Info -->
            <div class="space-y-3 flex-1 text-center sm:text-left">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h2 class="text-2xl font-display font-extrabold text-slate-900">{{ $student->full_name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                        Top Performer
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                        Dean's List
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        {{ $student->status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-xs text-slate-600 pt-1">
                    <div>
                        <span class="text-slate-400 font-semibold">Roll Number:</span>
                        <span class="font-mono font-bold text-slate-900 ml-1">#{{ $student->admission_number }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Department:</span>
                        <span class="font-bold text-slate-900 ml-1">{{ $student->department?->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Current Semester:</span>
                        <span class="font-bold text-slate-900 ml-1">Semester {{ $student->current_semester }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Email:</span>
                        <span class="text-indigo-600 ml-1 font-medium">{{ $student->email }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Phone:</span>
                        <span class="text-slate-800 ml-1">{{ $student->phone ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Enrolled Since:</span>
                        <span class="text-slate-800 ml-1">{{ $student->enrollment_date->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">Guardian:</span>
                        <span class="text-slate-800 ml-1">{{ $student->guardian_name ?? 'N/A' }} ({{ $student->guardian_phone ?? '' }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-semibold">City / Location:</span>
                        <span class="text-slate-800 ml-1">{{ $student->city ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Attendance Donut Gauge (4 Cols) - Matches Canva Mockup -->
        <div class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
            <h3 class="text-xs uppercase font-bold text-slate-500 tracking-wider mb-2">Overall Attendance Rate</h3>

            <div class="relative w-32 h-32 flex items-center justify-center my-3">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-slate-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-emerald-500 stroke-current" stroke-width="3.5" stroke-dasharray="{{ $attendanceRate }}, 100" stroke-linecap="round" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <div class="absolute text-center">
                    <span class="text-2xl font-display font-extrabold text-slate-900">{{ $attendanceRate }}%</span>
                </div>
            </div>

            <p class="text-xs font-semibold text-slate-700">Attended {{ $attendancePresent }} of {{ $attendanceTotal > 0 ? $attendanceTotal : 'N/A' }} logged sessions</p>
            <p class="text-[11px] text-emerald-600 font-medium mt-1">Excellent attendance standing</p>
        </div>
    </div>

    <!-- Academic Records & Grades (Matching Canva Mockup 2) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-3">
            <div>
                <h3 class="font-display font-bold text-slate-900 text-base">Academic Performance & Semester Grades</h3>
                <p class="text-xs text-slate-500">Subject-wise examination scores and cumulative grade point average</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <span class="text-xs text-slate-400">Cumulative GPA:</span>
                    <span class="text-base font-display font-extrabold text-emerald-600 ml-1">★ {{ $gpa }} / 4.00</span>
                </div>
                <button onclick="document.getElementById('modal-add-grade').classList.remove('hidden')" class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-sm">
                    + Record Grade
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 uppercase text-[11px] tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Subject Code</th>
                        <th class="py-3 px-4 font-semibold">Subject Name</th>
                        <th class="py-3 px-4 font-semibold">Credits</th>
                        <th class="py-3 px-4 font-semibold">Exam Type</th>
                        <th class="py-3 px-4 font-semibold">Marks</th>
                        <th class="py-3 px-4 font-semibold">Grade</th>
                        <th class="py-3 px-4 font-semibold">Points</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($student->grades as $grade)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-700">{{ $grade->course?->course_code ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $grade->course?->course_name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-medium">{{ $grade->course?->credits ?? 3 }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $grade->exam_type }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ number_format($grade->marks_obtained, 1) }} / {{ number_format($grade->total_marks, 0) }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-md font-bold text-xs bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $grade->grade_letter }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-extrabold text-slate-900">{{ number_format($grade->grade_point, 2) }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this grade entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-6 text-center text-slate-400">No examination grades recorded yet for this student.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Row: Fee Invoices & Enrolled Courses Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Fee Payment History (Canva Mockup 2 Replica) -->
        <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <h3 class="font-display font-bold text-slate-900 text-base">Fee Payment History</h3>
                <span class="text-xs text-slate-500">Invoices & Receipts</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-[11px] uppercase text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">Invoice #</th>
                            <th class="py-2.5 px-3">Description</th>
                            <th class="py-2.5 px-3">Amount</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Receipt</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($student->feeInvoices as $invoice)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3 font-mono font-bold text-slate-800">{{ $invoice->invoice_number }}</td>
                                <td class="py-3 px-3 font-medium text-slate-700">{{ $invoice->title }}</td>
                                <td class="py-3 px-3 font-bold text-slate-900">${{ number_format($invoice->amount, 2) }}</td>
                                <td class="py-3 px-3">
                                    @if($invoice->payment_status === 'Paid')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            PAID
                                        </span>
                                    @elseif($invoice->payment_status === 'Partial')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                            PARTIAL
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                            UNPAID
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('fees.receipt', $invoice->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-bold underline">
                                        View Receipt
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-400">No invoices on file.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enrolled Courses List -->
        <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <h3 class="font-display font-bold text-slate-900 text-base">Enrolled Courses</h3>
                <button onclick="document.getElementById('modal-enroll').classList.remove('hidden')" class="text-xs text-indigo-600 font-bold hover:underline">
                    + Enroll Course
                </button>
            </div>

            <div class="space-y-3">
                @forelse($student->courses as $course)
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <div class="font-mono text-xs font-bold text-indigo-700">{{ $course->course_code }}</div>
                            <div class="font-semibold text-slate-900 text-xs">{{ $course->course_name }}</div>
                            <div class="text-[11px] text-slate-400">Instructor: {{ $course->instructor_name ?? 'Faculty Staff' }}</div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 rounded-lg bg-indigo-100 text-indigo-800 font-bold text-xs">
                                {{ $course->credits }} Credits
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-slate-400 text-xs">Not enrolled in any courses yet.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- Modal 1: Record Grade -->
<div id="modal-add-grade" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-display font-bold text-slate-900 text-base">Record Exam Grade</h3>
            <button onclick="document.getElementById('modal-add-grade').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>
        <form action="{{ route('grades.store') }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Select Course</label>
                <select name="course_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    @foreach($student->courses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Assessment / Exam Type</label>
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
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Marks Obtained</label>
                    <input type="number" step="0.1" name="marks_obtained" required placeholder="e.g. 92.5" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Total Marks</label>
                    <input type="number" step="0.1" name="total_marks" value="100" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Instructor Remarks</label>
                <input type="text" name="remarks" placeholder="Optional comments..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t">
                <button type="button" onclick="document.getElementById('modal-add-grade').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm">Save Grade</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Enroll Course -->
<div id="modal-enroll" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-display font-bold text-slate-900 text-base">Enroll Student in Course</h3>
            <button onclick="document.getElementById('modal-enroll').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>
        <form action="{{ route('students.enroll', $student->id) }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Available Department Courses</label>
                <select name="course_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    @forelse($availableCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }} ({{ $course->credits }} cr)</option>
                    @empty
                        <option value="">No other courses available in this department</option>
                    @endforelse
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Academic Semester</label>
                <input type="text" name="semester" value="Semester {{ $student->current_semester }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t">
                <button type="button" onclick="document.getElementById('modal-enroll').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm">Enroll Now</button>
            </div>
        </form>
    </div>
</div>
@endsection
