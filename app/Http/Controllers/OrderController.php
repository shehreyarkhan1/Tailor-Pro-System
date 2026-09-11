<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Staff;
use App\Models\StyleCategory;
use App\Models\StyleOption;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['customer', 'assignedStaff'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, function ($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                    ->orWhereHas('customer', fn ($c) => $c->where('name', 'like', "%{$request->search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', compact('orders'));
    }

    // create() method ko is se replace karain:
    public function create(Request $request)
    {
        $customers = Customer::orderBy('name')->get();
        $staff = Staff::where('is_active', true)->orderBy('name')->get();
        $styleCategories = StyleCategory::where('is_active', true)
            ->with('activeOptions')
            ->orderBy('sort_order')
            ->get();
        $selectedCustomer = $request->customer_id ? Customer::with('measurements')->find($request->customer_id) : null;

        return view('orders.create', compact('customers', 'staff', 'styleCategories', 'selectedCustomer'));
    }

    // store() method ko is se replace karain:
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'measurement_id' => 'nullable|exists:measurements,id',
            'assigned_staff_id' => 'nullable|exists:staff,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'priority' => 'required|in:normal,urgent',
            'advance_paid' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.fabric_style' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'style_selections' => 'nullable|array',
            'style_selections.*' => 'nullable|integer|exists:style_options,id',
        ]);

        $itemsTotal = collect($validated['items'])->sum(fn ($item) => $item['quantity'] * $item['unit_price']);

        // Selected style options ka extra_price total mein jorain
        $styleSelections = array_filter($validated['style_selections'] ?? []);
        $styleExtraTotal = $styleSelections
            ? StyleOption::whereIn('id', $styleSelections)->sum('extra_price')
            : 0;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'customer_id' => $validated['customer_id'],
            'measurement_id' => $validated['measurement_id'] ?? null,
            'assigned_staff_id' => $validated['assigned_staff_id'] ?? null,
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'],
            'status' => 'pending',
            'priority' => $validated['priority'],
            'total_amount' => $itemsTotal + $styleExtraTotal,
            'advance_paid' => $validated['advance_paid'] ?? 0,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['items'] as $item) {
            $order->items()->create($item);
        }

        // style_selections array shape: [category_id => option_id]
        foreach ($styleSelections as $categoryId => $optionId) {
            $order->styleSelections()->create([
                'style_category_id' => $categoryId,
                'style_option_id' => $optionId,
            ]);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order successfully create ho gaya!');
    }

    public function show(Order $order)
    {
        $order->load([
            'customer', 'measurement', 'assignedStaff', 'items', 'invoice',
            'styleSelections.category', 'styleSelections.option',
        ]);
        $staff = Staff::where('is_active', true)->orderBy('name')->get();

        return view('orders.show', compact('order', 'staff'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,cutting,stitching,finishing,ready,delivered,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Order status update ho gaya: '.ucfirst($validated['status']));
    }

    public function assignStaff(Request $request, Order $order)
    {
        $validated = $request->validate([
            'assigned_staff_id' => 'nullable|exists:staff,id',
        ]);

        $order->update($validated);

        return back()->with('success', 'The Karigar has assign !');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order delete kar diya gaya.');
    }
}
