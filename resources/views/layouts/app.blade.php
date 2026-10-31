<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — SMS EduPortal</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            navy: '#1E1B4B',
                            dark: '#0F172A',
                            indigo: '#4F46E5',
                            accent: '#06B6D4',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Header -->
    <div class="md:hidden bg-[#1E1B4B] text-white p-4 flex items-center justify-between no-print shadow-md">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🎓</span>
            <span class="font-display font-bold text-lg tracking-tight">SMS EduPortal</span>
        </div>
        <button onclick="toggleMobileMenu()" class="p-2 text-slate-300 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation (Matches Canva Mockup) -->
    <aside id="sidebar-menu" class="hidden md:flex flex-col w-full md:w-64 bg-[#121124] text-slate-300 min-h-screen p-5 flex-shrink-0 no-print transition-all border-r border-slate-800">
        <!-- Brand Logo -->
        <div class="flex items-center gap-3 pb-6 border-b border-slate-800/80">
            <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-indigo-600/40">
                🎓
            </div>
            <div>
                <h1 class="font-display font-extrabold text-white text-lg tracking-tight leading-tight">SMS PORTAL</h1>
                <p class="text-[11px] text-indigo-400 font-semibold tracking-wider uppercase">Edu Management</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-6 space-y-1.5 flex-1">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('students.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span>Students</span>
            </a>

            <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('courses.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Courses</span>
            </a>

            <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('attendance.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Attendance</span>
            </a>

            <a href="{{ route('fees.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('fees.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Fees & Finance</span>
            </a>

            <a href="{{ route('grades.index') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('grades.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Exams & Marks</span>
            </a>
        </nav>

        <!-- Admin Profile Pill -->
        <div class="pt-6 border-t border-slate-800 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-700/80 border border-indigo-400/40 flex items-center justify-center font-bold text-white text-sm shadow">
                JD
            </div>
            <div class="overflow-hidden">
                <div class="text-xs font-bold text-white truncate">John Doe</div>
                <div class="text-[11px] text-slate-400 truncate">Administrator</div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        <!-- Top App Bar -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between no-print sticky top-0 z-20">
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <form action="{{ route('students.index') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students, courses, roll number..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
            </div>

            <div class="flex items-center gap-4 ml-4">
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-semibold text-slate-800">{{ date('l, F j, Y') }}</div>
                    <div class="text-[11px] text-slate-500">Academic Term 2026</div>
                </div>

                <a href="{{ route('students.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-sm shadow-indigo-600/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>New Student</span>
                </a>
            </div>
        </header>

        <!-- Main Content Body -->
        <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto space-y-6">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg leading-none">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm space-y-1">
                    <div class="font-bold">Please check the form for errors:</div>
                    <ul class="list-disc list-inside text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 px-6 text-center text-xs text-slate-500 no-print">
            <p>Student Management System (Laravel 9 + PHP 8 + MySQL) • Designed with Canva Blueprint</p>
        </footer>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('sidebar-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
