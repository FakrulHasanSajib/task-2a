<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
        .table-auto {
            border-collapse: collapse;
        }
        .table-auto th, .table-auto td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }
        .table-auto thead th {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg" id="print-area">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Purchase Orders Details</h1>
            <button onclick="window.print()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18h12m-6 3a3 3 0 100-6m0 6a3 3 0 100-6m0 6a3 3 0 100-6"></path></svg>
                Print
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div>
                <span class="font-semibold text-gray-700">Supplier:</span> {{ $purchase->supplier->name }}
            </div>
            <div class="md:col-span-2 text-right">
                <span class="font-semibold text-gray-700">ORDER NO.</span>: {{ $purchase->order_no }}
                <br>
                <span class="font-semibold text-gray-700">DATE:</span> {{ $purchase->date }}
            </div>
        </div>

        <div class="overflow-x-auto mb-6">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4">S/L</th>
                        <th class="py-2 px-4">Brand</th>
                        <th class="py-2 px-4">Category</th>
                        <th class="py-2 px-4">Product</th>
                        <th class="py-2 px-4">Code</th>
                        <th class="py-2 px-4">Unit</th>
                        <th class="py-2 px-4">Pur. Unit Price</th>
                        <th class="py-2 px-4">Quantity</th>
                        <th class="py-2 px-4">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_quantity = 0; $grand_total = 0; @endphp
                    @foreach($purchase->details as $index => $detail)
                        <tr>
                            <td class="py-2 px-4">{{ $index + 1 }}</td>
                            <td class="py-2 px-4">{{ $detail->brand->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $detail->category->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $detail->product->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $detail->product->product_code ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $detail->unit->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ number_format($detail->pur_unit_price, 2) }}</td>
                            <td class="py-2 px-4">{{ $detail->quantity }}</td>
                            <td class="py-2 px-4">{{ number_format($detail->total_price, 2) }}</td>
                        </tr>
                        @php
                            $total_quantity += $detail->quantity;
                            $grand_total += $detail->total_price;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-right font-bold">Total</td>
                        <td class="font-bold">{{ $total_quantity }}</td>
                        <td class="font-bold">{{ number_format($grand_total, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-bold">Payment</td>
                        <td class="font-bold">{{ number_format($purchase->paid, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-bold">Due</td>
                        <td class="font-bold">{{ number_format($purchase->due, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        @if($purchase->notes)
            <div class="mb-4">
                <h3 class="font-semibold text-gray-700">Notes:</h3>
                <p class="text-gray-600">{{ $purchase->notes }}</p>
            </div>
        @endif
    </div>
</body>
</html>
