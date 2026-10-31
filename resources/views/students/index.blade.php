@extends('layouts.app')

@section('title', 'Students Directory')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Student Directory</h1>
            <p class="text-sm text-slate-500 mt-1">Manage enrollments, academic transcripts, and personal profiles.</p>
        </div>
        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30 self-start sm:self-auto">
            <span>➕ Register New Student</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('students.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Search Keyword</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Roll No, or Email..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
            </div>

            <!-- Department Filter -->
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

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Graduated" {{ request('status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                    <option value="Suspended" {{ request('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-3 rounded-xl transition shadow-sm">
                    Filter
                </button>
                <a href="{{ route('students.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold py-2 px-3 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Students Data Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-6 font-semibold">Student Profile</th>
                        <th class="py-3.5 px-4 font-semibold">Admission / Roll</th>
                        <th class="py-3.5 px-4 font-semibold">Department</th>
                        <th class="py-3.5 px-4 font-semibold">Current Sem</th>
                        <th class="py-3.5 px-4 font-semibold">Contact</th>
                        <th class="py-3.5 px-4 font-semibold">Status</th>
                        <th class="py-3.5 px-6 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-600 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('students.show', $student->id) }}" class="font-bold text-slate-900 hover:text-indigo-600 text-sm">
                                        {{ $student->full_name }}
                                    </a>
                                    <div class="text-[11px] text-slate-400">{{ $student->email }}</div>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono font-semibold text-slate-700">
                                {{ $student->admission_number }}
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-700">
                                <span class="px-2 py-0.5 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700 font-semibold">
                                    {{ $student->department?->code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-700">
                                Sem {{ $student->current_semester }}
                            </td>
                            <td class="py-4 px-4 text-slate-500">
                                {{ $student->phone ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-4">
                                @if($student->status === 'Active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        {{ $student->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('students.show', $student->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition" title="View Detailed Profile">
                                        👁️
                                    </a>
                                    <a href="{{ route('students.id_card', $student->id) }}" target="_blank" class="p-1.5 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-slate-100 transition" title="Print Student ID Card">
                                        🪪
                                    </a>
                                    <a href="{{ route('students.edit', $student->id) }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-slate-100 transition" title="Edit Student">
                                        ✏️
                                    </a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete {{ $student->full_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="text-3xl mb-2">🔍</div>
                                <div class="text-sm font-semibold">No students found</div>
                                <div class="text-xs text-slate-400">Try adjusting your search criteria or register a new student.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $students->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
