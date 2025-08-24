<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * পারচেজ অর্ডারের তালিকা দেখানোর জন্য
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::with('supplier');

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->input('supplier_id'));
        }
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->input('end_date'));
        }

        $purchaseOrders = $query->paginate(10);
        $suppliers = Supplier::all();

        return view('purchaseOrders.index', compact('purchaseOrders', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     * নতুন পারচেজ অর্ডারের ফর্ম দেখানোর জন্য
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('purchaseOrders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     * ফর্ম থেকে আসা ডেটা সেভ করার জন্য
     */
    public function store(Request $request)
    {
        // 1. ইনপুট ডেটা যাচাই (Validate) করা
        $validatedData = $request->validate([
            'order_no' => 'required|string|unique:purchase_orders,order_no',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        
        // 2. মূল Purchase Order তৈরি করা
        $purchaseOrder = PurchaseOrder::create([
            'order_no' => $validatedData['order_no'],
            'supplier_id' => $validatedData['supplier_id'],
            'date' => $validatedData['date'],
            'total' => $validatedData['total'],
            'due' => $validatedData['total'],
            'status' => 'Pending',
        ]);

        // 3. প্রতিটি আইটেমকে লুপ করে purchase_order_items টেবিলে সেভ করা
        foreach ($validatedData['items'] as $item) {
            // product_id ব্যবহার করে ডাটাবেস থেকে পণ্যের বিবরণ খুঁজে বের করা হচ্ছে
            $product = Product::find($item['product_id']);

            // **এখানে মূল পরিবর্তন:** যদি পণ্য খুঁজে না পাওয়া যায়, তাহলে একটি ত্রুটি ছুঁড়ে দিন
            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => ['Selected product not found.'],
                ]);
            }

            $purchaseOrder->items()->create([
                'product_id' => $product->id,
                'brand' => $product->brand,
                'category' => $product->category,
                'code' => $product->code,
                'unit' => $product->unit,
                'pur_unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        // 4. সফলভাবে সেভ হলে তালিকা পেজে রিডাইরেক্ট করা
        return redirect()->route('purchase-orders.index')->with('success', 'Purchase Order and its items created successfully!');
    }

    /**
     * Display the specified resource.
     * একটি নির্দিষ্ট পারচেজ অর্ডারের বিস্তারিত দেখানোর জন্য
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'items');

        return view('purchaseOrders.show', compact('purchaseOrder'));
    }
}
