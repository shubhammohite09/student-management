<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipt — {{ $invoice->invoice_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .receipt-box { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-4 sm:p-8 flex flex-col items-center justify-center">

    <div class="mb-6 flex items-center gap-3 no-print">
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md transition flex items-center gap-2">
            <span>🖨️ Print Official Receipt</span>
        </button>
        <button onclick="window.close()" class="px-4 py-2.5 rounded-xl bg-white text-slate-700 font-bold text-xs shadow-sm hover:bg-slate-50 transition">
            Close Window
        </button>
    </div>

    <!-- Receipt Container -->
    <div class="receipt-box max-w-2xl w-full bg-white rounded-3xl shadow-xl border border-slate-200 p-8 sm:p-10 space-y-6">

        <!-- Institution Header -->
        <div class="flex items-start justify-between border-b border-slate-200 pb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold shadow-md">
                    🎓
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-xl text-slate-900 tracking-tight">SMS EDU PORTAL</h1>
                    <p class="text-xs text-slate-500">Official Campus Bursar & Accounts Office</p>
                    <p class="text-[11px] text-slate-400">100 University Boulevard, Academic City</p>
                </div>
            </div>

            <div class="text-right">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                    RECEIPT
                </span>
                <div class="text-xs font-mono font-bold text-slate-800 mt-2">#{{ $invoice->invoice_number }}</div>
                <div class="text-[11px] text-slate-400">Date: {{ date('M d, Y') }}</div>
            </div>
        </div>

        <!-- Student & Billing Details -->
        <div class="grid grid-cols-2 gap-6 text-xs border-b border-slate-100 pb-6">
            <div>
                <span class="text-slate-400 font-semibold uppercase block mb-1">Student Details</span>
                <div class="font-bold text-slate-900 text-sm">{{ $invoice->student?->full_name }}</div>
                <div class="font-mono text-slate-600 mt-0.5">Roll No: #{{ $invoice->student?->admission_number }}</div>
                <div class="text-slate-600">Dept: {{ $invoice->student?->department?->name }} (Sem {{ $invoice->student?->current_semester }})</div>
                <div class="text-slate-600">{{ $invoice->student?->email }}</div>
            </div>

            <div class="text-right">
                <span class="text-slate-400 font-semibold uppercase block mb-1">Payment Information</span>
                <div class="font-bold text-slate-800">Status: <span class="text-emerald-600 font-extrabold uppercase">{{ $invoice->payment_status }}</span></div>
                <div class="text-slate-600 mt-0.5">Method: {{ $invoice->payment_method ?? 'Campus Bursar' }}</div>
                <div class="text-slate-600">Processed At: {{ $invoice->paid_at ? $invoice->paid_at->format('M d, Y h:i A') : 'Pending' }}</div>
            </div>
        </div>

        <!-- Line Item Table -->
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-slate-400 uppercase border-b border-slate-200 pb-2">
                    <th class="py-2">Item Description</th>
                    <th class="py-2 text-right">Due Date</th>
                    <th class="py-2 text-right">Amount Billed</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                <tr>
                    <td class="py-3 font-semibold text-slate-900">
                        {{ $invoice->title }}
                        @if($invoice->notes)
                            <div class="text-[11px] font-normal text-slate-500 mt-0.5">{{ $invoice->notes }}</div>
                        @endif
                    </td>
                    <td class="py-3 text-right text-slate-500">{{ $invoice->due_date->format('M d, Y') }}</td>
                    <td class="py-3 text-right font-bold text-slate-900">${{ number_format($invoice->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals & Balances -->
        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-2 text-xs">
            <div class="flex justify-between">
                <span class="text-slate-500 font-semibold">Total Fee Invoiced:</span>
                <span class="font-bold text-slate-900">${{ number_format($invoice->amount, 2) }}</span>
            </div>
            <div class="flex justify-between text-emerald-700 font-bold">
                <span>Amount Paid to Date:</span>
                <span>${{ number_format($invoice->paid_amount, 2) }}</span>
            </div>
            <div class="flex justify-between border-t border-slate-200 pt-2 text-sm font-extrabold">
                <span class="text-slate-800">Remaining Balance Due:</span>
                <span class="text-slate-900">${{ number_format(max(0, $invoice->amount - $invoice->paid_amount), 2) }}</span>
            </div>
        </div>

        <!-- Signature & Stamp Section -->
        <div class="pt-8 flex items-end justify-between border-t border-slate-200">
            <div>
                <!-- Simulated Official Stamp -->
                <div class="inline-flex flex-col items-center justify-center p-3 rounded-2xl border-2 border-emerald-600/60 text-emerald-700 rotate-[-4deg] opacity-90 select-none">
                    <span class="text-[10px] font-extrabold tracking-widest uppercase">SMS EDU BURSAR</span>
                    <span class="text-base font-display font-extrabold tracking-wider">★ OFFICIAL PAID ★</span>
                    <span class="text-[9px] font-mono font-semibold">{{ date('Y-m-d') }} VERIFIED</span>
                </div>
            </div>

            <div class="text-center w-48">
                <div class="border-b border-slate-400 pb-1 mb-1 font-serif italic text-sm text-slate-700">M. Sterling</div>
                <div class="text-[11px] font-bold text-slate-600">Authorized Bursar Signatory</div>
                <div class="text-[10px] text-slate-400">Student Accounts Division</div>
            </div>
        </div>

        <div class="text-center text-[10px] text-slate-400 pt-2">
            This is a computer-generated receipt issued by SMS EduPortal. Retain this voucher for examination clearance.
        </div>

    </div>

</body>
</html>
