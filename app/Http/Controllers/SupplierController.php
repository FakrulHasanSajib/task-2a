<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller

{
      public function create()
    {
        return view('suppliers.create'); // resources/views/suppliers/create.blade.php
    }
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('suppliers.index', compact('suppliers'));
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'mobile_no' => 'required', // নতুন যোগ করা হয়েছে
        'email' => 'nullable|email|unique:suppliers,email',
        'status' => 'required|boolean', // নতুন যোগ করা হয়েছে
    ]);

    Supplier::create($request->all());
    return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
}
public function edit(Supplier $supplier)
{
    return view('suppliers.edit', compact('supplier'));
}

public function update(Request $request, Supplier $supplier)
{
    $request->validate([
        'name' => 'required|max:255',
        'mobile_no' => 'required', // নতুন যোগ করা হয়েছে
        'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
        'status' => 'required|boolean', // নতুন যোগ করা হয়েছে
    ]);

    $supplier->update($request->all());
    return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully!');
}

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully!');
    }
}