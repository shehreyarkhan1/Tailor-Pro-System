<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('order.customer')->when($request->status, fn ($q) => $q->where('status', $request->status))->latest()->
        paginate(12)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    public function create(Order $order)
    {
        return view('invoices.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'issue_date' => 'required|date',
        ]);
        $status = 'unpaid';
        if ($validated['paid_amount'] >= $validated['amount']) {
            $status = 'paid';
        } elseif ($validated['paid_amount'] > 0) {
            $status = 'partial';
        }

        $invoice = Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'order_id' => $order->id,
            'amount' => $validated['amount'],
            'paid_amount' => $validated['paid_amount'],
            'status' => $status,
            'issue_date' => $validated['issue_date'],
        ]);

        return redirect()->route('invoices.show',$invoice)->with('success', 'Invoice Create Successfully');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('order.customer', 'order.items');

        return view('invoices.show', compact('invoice'));
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
        $newPaid = min($invoice->amount, $invoice->paid_amount + $validated['amount']);
        $status = $newPaid >= $invoice->amount ? 'paid' : 'partial';
        $invoice->update(['paid_amount' => $newPaid, 'status' => $status]);

        return back()->with('success', 'Payment recorded successfully');

    }
}
