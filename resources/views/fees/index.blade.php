@extends('layouts.app')

@section('title', 'Fees & Finance')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-extrabold text-slate-900 tracking-tight">Fee Management & Invoicing</h1>
            <p class="text-sm text-slate-500 mt-1">Generate fee bills, process student tuition payments, and issue printable receipts.</p>
        </div>
        <button onclick="document.getElementById('modal-create-invoice').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/30 self-start sm:self-auto">
            <span>➕ Generate Fee Invoice</span>
        </button>
    </div>

    <!-- Financial KPI Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Fees Billed</span>
            <div class="text-3xl font-display font-extrabold text-slate-900">${{ number_format($totalBilled, 2) }}</div>
            <p class="text-xs text-slate-400 mt-1">All registered student fee invoices</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">Total Collected</span>
            <div class="text-3xl font-display font-extrabold text-emerald-600">${{ number_format($totalCollected, 2) }}</div>
            <p class="text-xs text-emerald-600/80 mt-1 font-medium">{{ $totalBilled > 0 ? round(($totalCollected / $totalBilled) * 100, 1) : 0 }}% revenue realized</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block mb-1">Outstanding Balance</span>
            <div class="text-3xl font-display font-extrabold text-amber-600">${{ number_format($totalOutstanding, 2) }}</div>
            <p class="text-xs text-amber-600/80 mt-1 font-medium">Pending or partially paid</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
        <form action="{{ route('fees.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Search Keyword</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Invoice #, title, or student name..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
            </div>

            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Payment Status</label>
                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-indigo-500">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Invoices</option>
                        <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                        <option value="Unpaid" {{ request('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-xl transition shadow-sm">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Invoices Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="font-display font-bold text-slate-900 text-base">Invoices Register ({{ $invoices->total() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 font-semibold">Invoice #</th>
                        <th class="py-3 px-4 font-semibold">Student Name</th>
                        <th class="py-3 px-4 font-semibold">Fee Title</th>
                        <th class="py-3 px-4 font-semibold">Due Date</th>
                        <th class="py-3 px-4 font-semibold">Amount</th>
                        <th class="py-3 px-4 font-semibold">Paid</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900">{{ $inv->invoice_number }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                <a href="{{ route('students.show', $inv->student_id) }}" class="hover:text-indigo-600">
                                    {{ $inv->student?->full_name }}
                                </a>
                                <span class="text-[11px] text-slate-400 block font-mono font-normal">{{ $inv->student?->admission_number }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-800">{{ $inv->title }}</td>
                            <td class="py-3.5 px-4 text-slate-500">{{ $inv->due_date->format('M d, Y') }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">${{ number_format($inv->amount, 2) }}</td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">${{ number_format($inv->paid_amount, 2) }}</td>
                            <td class="py-3.5 px-4">
                                @if($inv->payment_status === 'Paid')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">PAID</span>
                                @elseif($inv->payment_status === 'Partial')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800 border border-amber-200">PARTIAL</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">UNPAID</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                @if($inv->payment_status !== 'Paid')
                                    <button onclick="openPayModal({{ $inv->id }}, '{{ $inv->invoice_number }}', {{ $inv->amount - $inv->paid_amount }})" class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 text-xs font-bold transition">
                                        Pay
                                    </button>
                                @endif
                                <a href="{{ route('fees.receipt', $inv->id) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition inline-block">
                                    Receipt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">No invoices match your criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($invoices->hasPages())
            <div class="pt-4 border-t border-slate-200">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal 1: Create Invoice -->
<div id="modal-create-invoice" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-display font-bold text-slate-900 text-base">Generate Fee Invoice</h3>
            <button onclick="document.getElementById('modal-create-invoice').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>
        <form action="{{ route('fees.store') }}" method="POST" class="space-y-3">
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
                <label class="block text-xs font-semibold text-slate-600 mb-1">Invoice Title *</label>
                <input type="text" name="title" required placeholder="e.g. Semester Tuition & Lab Fee" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Fee Amount ($) *</label>
                    <input type="number" step="0.01" name="amount" required placeholder="2450.00" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Payment Due Date *</label>
                    <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+30 days')) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Fee Breakdown Notes</label>
                <textarea name="notes" rows="2" placeholder="Tuition $2,200 + Lab $250..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t">
                <button type="button" onclick="document.getElementById('modal-create-invoice').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-sm">Create Invoice</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Record Payment -->
<div id="modal-pay" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-display font-bold text-slate-900 text-base">Record Payment: <span id="pay-inv-number" class="text-indigo-600 font-mono"></span></h3>
            <button onclick="document.getElementById('modal-pay').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
        </div>
        <form id="pay-form" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Payment Amount ($) *</label>
                <input type="number" step="0.01" name="payment_amount" id="pay-amount-input" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-900">
                <span class="text-[11px] text-slate-400">Remaining Due: $<span id="pay-remaining-due"></span></span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Payment Method *</label>
                <select name="payment_method" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <option value="Online Portal">Online Portal / Credit Card</option>
                    <option value="Bank Transfer">Bank Wire Transfer</option>
                    <option value="Cash">Cash at Bursar Office</option>
                    <option value="Cheque">Banker's Cheque</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t">
                <button type="button" onclick="document.getElementById('modal-pay').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-bold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-xs font-bold shadow-sm">Confirm Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openPayModal(id, invoiceNumber, remaining) {
        document.getElementById('pay-inv-number').innerText = invoiceNumber;
        document.getElementById('pay-remaining-due').innerText = remaining.toFixed(2);
        document.getElementById('pay-amount-input').value = remaining.toFixed(2);
        document.getElementById('pay-amount-input').max = remaining;
        document.getElementById('pay-form').action = '/fees/' + id + '/pay';
        document.getElementById('modal-pay').classList.remove('hidden');
    }
</script>
@endsection
