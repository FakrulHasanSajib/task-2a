<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- সফলতার বার্তা দেখানোর জন্য -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">Purchase Orders List</h2>

        <div class="mb-3">
            <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">Create New Purchase Order</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Supplier</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseOrders as $order)
                    <tr>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $order->date }}</td>
                        <td>{{ number_format($order->total, 2) }}</td>
                        <td>{{ number_format($order->due, 2) }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            <a href="{{ route('purchase-orders.show', $order) }}" class="btn btn-info btn-sm">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No purchase orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>