<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::withCount('orders')->when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")->
            orWhere('phone', 'like', "%{$request->search}%")->orWhere('customer_code', 'like', "%{$request->search}%");
        })->latest()->paginate(12)->withQueryString();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsaap' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'required|in:male,female,kids',
            'city' => 'nullable|string|max:200',
            'notes' => 'nullable|string',
            'is_vip' => 'nullable|boolean',
        ]);
        $validated['customer_code'] = Customer::generateCode();
        $validated['is_vip'] = $request->boolean('is_vip');
        $customer = Customer::create($validated);

        return redirect()->route('customers.show', $customer)->with('success', 'Customer Created Successfully');
    }

    public function show(Customer $customer)
    {
        $customer->load(['measurements' => fn ($q) => $q->latest(), 'orders' => fn ($q) => $q->latest()]);

        return view('customers.show', compact('customer'));

    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'whatsaap' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'required|in:male,female,kids',
            'city' => 'nullable|string|max:200',
            'notes' => 'nullable|string',
            'is_vip' => 'nullable|boolean',
        ]);
        $validated['is_vip'] = $request->boolean('is_vip');
        $customer->update($validated);

        return redirect()->route('customers.show', $customer)->with('success', 'Customer Updated Successfully');

    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer Deleted Successfully');
    }

    public function storeMeasurement(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'garment_type' => 'required|in:shalwar_qameez,kurta_pajama,waistcoat,coat_pant,kids_wear,other',
            'length' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'hips' => 'nullable|numeric',
            'shoulder' => 'nullable|numeric',
            'sleeve_length' => 'nullable|numeric',
            'collar' => 'nullable|numeric',
            'armhole' => 'nullable|numeric',
            'bicep' => 'nullable|numeric',
            'shalwar_length' => 'nullable|numeric',
            'paincha' => 'nullable|numeric',
            'style_notes' => 'nullable|string',
        ]);
        $customer->measurements()->create($validated);

        return redirect()->route('customers.show', $customer)->with('success', 'Measurement Added Successfully');

    }
}
