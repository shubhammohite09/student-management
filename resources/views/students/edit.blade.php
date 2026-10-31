@extends('layouts.app')

@section('title', 'Edit Student: ' . $student->full_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('students.index') }}" class="hover:text-indigo-600">Students</a>
                <span>›</span>
                <a href="{{ route('students.show', $student->id) }}" class="hover:text-indigo-600">{{ $student->full_name }}</a>
                <span>›</span>
                <span class="text-slate-800 font-semibold">Edit</span>
            </div>
            <h1 class="text-2xl font-display font-bold text-slate-900 tracking-tight">Edit Student Details</h1>
        </div>
        <a href="{{ route('students.show', $student->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
            ← Back to Profile
        </a>
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
        @csrf
        @method('PUT')

        <!-- Section 1: Academic Enrollment -->
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm border-b pb-2 mb-4 flex items-center gap-2">
                <span>🎓</span> <span>Academic & Department Assignment</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Admission / Roll Number *</label>
                    <input type="text" name="admission_number" value="{{ old('admission_number', $student->admission_number) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 font-mono font-bold focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Academic Department *</label>
                    <select name="department_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $student->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }} ({{ $dept->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Current Semester *</label>
                    <select name="current_semester" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}" {{ old('current_semester', $student->current_semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Enrollment Date *</label>
                    <input type="date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date->format('Y-m-d')) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Enrollment Status *</label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                        <option value="Active" {{ old('status', $student->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $student->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Graduated" {{ old('status', $student->status) == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="Suspended" {{ old('status', $student->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Personal Details -->
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm border-b pb-2 mb-4 flex items-center gap-2">
                <span>👤</span> <span>Personal Details</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Gender *</label>
                    <select name="gender" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                        <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Date of Birth *</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth->format('Y-m-d')) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', $student->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Section 3: Contact & Guardian Info -->
        <div>
            <h2 class="font-display font-bold text-slate-900 text-sm border-b pb-2 mb-4 flex items-center gap-2">
                <span>🏠</span> <span>Residential & Guardian Information</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Street Address</label>
                    <input type="text" name="address" value="{{ old('address', $student->address) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">City / Region</label>
                    <input type="text" name="city" value="{{ old('city', $student->city) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Guardian Name</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Guardian Contact Phone</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
            <a href="{{ route('students.show', $student->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30">
                Save Changes
            </button>
        </div>
    </form>

</div>
@endsection
