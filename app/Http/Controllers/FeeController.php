<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeInvoice;
use App\Models\Student;
use Carbon\Carbon;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = FeeInvoice::with('student.department');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('admission_number', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(10)->withQueryString();

        // Financial totals
        $totalBilled = FeeInvoice::sum('amount');
        $totalCollected = FeeInvoice::sum('paid_amount');
        $totalOutstanding = $totalBilled - $totalCollected;

        $students = Student::orderBy('first_name')->get();

        return view('fees.index', compact('invoices', 'totalBilled', 'totalCollected', 'totalOutstanding', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:150',
            'amount' => 'required|numeric|min:1',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $nextId = (FeeInvoice::max('id') ?? 0) + 1;
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        FeeInvoice::create([
            'student_id' => $validated['student_id'],
            'invoice_number' => $invoiceNumber,
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'paid_amount' => 0.00,
            'due_date' => $validated['due_date'],
            'payment_status' => 'Unpaid',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('fees.index')->with('success', "Fee invoice {$invoiceNumber} generated successfully!");
    }

    public function recordPayment(Request $request, $id)
    {
        $invoice = FeeInvoice::findOrFail($id);

        $request->validate([
            'payment_amount' => 'required|numeric|min:1|max:' . ($invoice->amount - $invoice->paid_amount),
            'payment_method' => 'required|string|in:Cash,Credit Card,Bank Transfer,Online Portal,Cheque',
        ]);

        $newPaid = $invoice->paid_amount + $request->payment_amount;
        $status = ($newPaid >= $invoice->amount) ? 'Paid' : 'Partial';

        $invoice->update([
            'paid_amount' => $newPaid,
            'payment_status' => $status,
            'payment_method' => $request->payment_method,
            'paid_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', "Payment of \${$request->payment_amount} recorded for invoice {$invoice->invoice_number}.");
    }

    public function receipt($id)
    {
        $invoice = FeeInvoice::with(['student.department'])->findOrFail($id);
        return view('fees.receipt', compact('invoice'));
    }
}
