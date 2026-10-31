<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card — {{ $student->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-200 min-h-screen p-6 flex flex-col items-center justify-center">

    <div class="mb-6 flex items-center gap-3 no-print">
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition flex items-center gap-2">
            <span>🖨️ Print Student ID Card</span>
        </button>
        <button onclick="window.close()" class="px-4 py-2.5 rounded-xl bg-white text-slate-700 font-bold text-xs shadow-sm hover:bg-slate-50 transition">
            Close Window
        </button>
    </div>

    <!-- Front & Back of ID Card (Standard CR80 dimensions: 3.375" x 2.125" ratio) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl">

        <!-- ID Card Front -->
        <div class="w-[340px] sm:w-[380px] h-[520px] bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-300 flex flex-col justify-between relative">
            <!-- Top Gradient Wave Header -->
            <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-indigo-950 p-6 text-white text-center relative overflow-hidden">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="flex items-center justify-center gap-2 mb-1">
                    <span class="text-2xl">🎓</span>
                    <span class="font-display font-extrabold text-lg tracking-wider">SMS EDU PORTAL</span>
                </div>
                <p class="text-[10px] text-indigo-300 font-bold tracking-widest uppercase">Student Identity Card</p>
            </div>

            <!-- Profile Photo & Details -->
            <div class="px-6 flex flex-col items-center text-center -mt-8 space-y-2 flex-1 justify-center">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 border-4 border-white shadow-xl flex items-center justify-center text-white text-3xl font-display font-extrabold">
                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                </div>

                <div class="pt-2">
                    <h2 class="text-xl font-display font-extrabold text-slate-900">{{ $student->full_name }}</h2>
                    <span class="text-xs font-mono font-bold text-indigo-600 tracking-wider">ROLL: {{ $student->admission_number }}</span>
                </div>

                <div class="w-full bg-slate-50 rounded-xl p-3 border border-slate-100 text-left space-y-1.5 text-xs">
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">Department:</span>
                        <span class="font-bold text-slate-800">{{ $student->department?->name ?? 'Computer Science' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">Current Term:</span>
                        <span class="font-bold text-slate-800">Semester {{ $student->current_semester }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400 font-semibold">Valid Thru:</span>
                        <span class="font-bold text-emerald-700">Aug 2027</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Barcode Area -->
            <div class="bg-slate-100 border-t border-slate-200 p-4 text-center">
                <!-- Barcode graphic simulation -->
                <div class="flex justify-center items-center gap-1 h-8 opacity-80">
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-1.5 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-0.5 h-full bg-black"></div>
                    <div class="w-2 h-full bg-black"></div>
                    <div class="w-1 h-full bg-black"></div>
                    <div class="w-1.5 h-full bg-black"></div>
                </div>
                <div class="text-[9px] font-mono text-slate-500 mt-1 uppercase tracking-widest">{{ $student->admission_number }} • SMS AUTHORIZED</div>
            </div>
        </div>

        <!-- ID Card Back -->
        <div class="w-[340px] sm:w-[380px] h-[520px] bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-300 flex flex-col justify-between p-6 text-xs text-slate-600">
            <div>
                <div class="text-center pb-3 border-b border-slate-200">
                    <h3 class="font-display font-extrabold text-slate-900 text-sm">CAMPUS REGULATIONS</h3>
                    <p class="text-[10px] text-slate-400">Institutional Terms of Possession</p>
                </div>

                <div class="space-y-3 pt-4 text-[11px] leading-relaxed">
                    <p>1. This card is the property of the University and must be surrendered upon request or withdrawal.</p>
                    <p>2. Mandatory for campus entry, library borrowing, examination halls, and computer laboratory access.</p>
                    <p>3. If found, please return to the Office of the Registrar, Campus Administration Building.</p>
                </div>
            </div>

            <div class="space-y-3 border-t border-slate-200 pt-3">
                <div class="text-[11px]">
                    <span class="text-slate-400 font-semibold block">Emergency Contact:</span>
                    <strong class="text-slate-800">{{ $student->guardian_name ?? 'Registrar Office' }} ({{ $student->guardian_phone ?? '+1 555-0199' }})</strong>
                </div>

                <div class="text-[11px]">
                    <span class="text-slate-400 font-semibold block">Residential Address:</span>
                    <span class="text-slate-700">{{ $student->address ?? 'Main Campus Residence' }}, {{ $student->city ?? '' }}</span>
                </div>

                <div class="pt-2 text-center border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400">
                    <span>Issued: {{ date('M Y') }}</span>
                    <span class="font-serif italic font-bold text-slate-700">Dean of Students</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
