<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::withCount('orders')->orderBy('name')->paginate(12);

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:225',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:master_tailor,cutter,stitcher,finisher,manager',
            'monthly_salary' => 'nullable|numeric|min:0',
        ]);
        $staff = Staff::create($validated);

        return redirect()->route('staff.index')->with('success', 'Staff Created Successfully');
    }

    public function edit(Staff $staff)
    {
        return view('staff.edit',compact('staff'));
    }

    public function update(Request $request ,Staff $staff)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:225',
            'phone'=>'nullable|string|max:20',
            'role'=>'required|in:master_tailor,cutter,stitcher,finisher,manager',
            'monthly_salary'=>'nullable|numeric|min:0',
            'is_active'=>'nullable|boolean',
        ]);
        $validated['is_active']=$request->boolean('is_active');
        $staff->update($validated);
        return redirect()->route('staff.index')->with('success','Staff update successfully updated');
    }
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success','Staff delete successfully ');
    }
}
