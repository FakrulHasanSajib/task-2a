<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .print-btn {
            margin-bottom: 20px;
        }
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-start print-btn">
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
    </div>

    <div class="card p-4">
        <h4 class="mb-4">Purchase Orders Details</h4>
        
        <div class="row mb-3">
            <div class="col-4"><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name ?? 'N/A' }}</div>
            <div class="col-4 text-center"><strong>ORDER NO:</strong> {{ $purchaseOrder->order_no }}</div>
            <div class="col-4 text-end"><strong>DATE:</strong> {{ \Carbon\Carbon::parse($purchaseOrder->date)->format('d-m-Y') }}</div>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr class="table-primary">
                    <th>S/L</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Code</th>
                    <th>Unit</th>
                    <th>Pur. Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->brand }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ number_format($item->pur_unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7"></td>
                    <td class="text-end"><strong>Total</strong></td>
                    <td class="fw-bold">{{ number_format($purchaseOrder->items->sum('total_price'), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td class="text-end"><strong>Payment</strong></td>
                    <td class="fw-bold">{{ number_format($purchaseOrder->paid, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
                    <td class="text-end"><strong>Due</strong></td>
                    <td class="fw-bold">{{ number_format($purchaseOrder->due, 2) }}</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>