<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get all suppliers to populate the filter dropdown
        $suppliers = Supplier::orderBy('name')->get();

        $query = Purchase::with('supplier');

        // Apply filters based on request
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $purchases = $query->orderBy('created_at', 'desc')->get();

        return view('purchases.index', compact('purchases', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        // Mock data for dropdowns, in a real app you'd fetch from DB
        $products = Product::with(['brand', 'category', 'unit'])->get();
        
        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Generate unique order number (e.g., PO-0001)
            $lastPurchase = Purchase::latest()->first();
            $orderNo = 'PO-' . ($lastPurchase ? str_pad($lastPurchase->id + 1, 4, '0', STR_PAD_LEFT) : '0001');

            $totalAmount = 0;
            $purchase = Purchase::create([
                'order_no' => $orderNo,
                'date' => $request->date,
                'supplier_id' => $request->supplier_id,
                'notes' => $request->notes,
                'status' => 'received', // Default status
            ]);

            foreach ($request->products as $item) {
                $product = Product::find($item['product_id']);
                $totalPrice = $item['quantity'] * $item['unit_price'];

                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'brand_id' => $product->brand_id, // Fetch from product model
                    'category_id' => $product->category_id,
                    'unit_id' => $product->unit_id,
                    'pur_unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $totalPrice,
                ]);

                $totalAmount += $totalPrice;
            }

            $purchase->update([
                'total' => $totalAmount,
                'due' => $totalAmount - $purchase->paid,
            ]);

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Purchase created successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create purchase: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'details.product', 'details.brand', 'details.category', 'details.unit');
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully!');
    }
}
