<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Purchase Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Create New Purchase Order</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('purchase-orders.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="order_no" class="form-label">Order No.</label>
                    <input type="text" class="form-control" id="order_no" name="order_no" required>
                </div>
                <div class="mb-3">
                    <label for="supplier" class="form-label">Supplier</label>
                    <select class="form-select" id="supplier" name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        Purchase Items
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="purchaseItemsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="items[0][product_id]" class="form-control" required>
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][quantity]" class="form-control quantity" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][unit_price]" step="0.01" class="form-control unit_price" required>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][total_price]" step="0.01" class="form-control total_price" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-secondary" id="addItemButton">Add Item</button>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="total" class="form-label fw-bold">Grand Total</label>
                    <input type="number" step="0.01" class="form-control" id="grand_total" name="total" readonly>
                </div>

                <button type="submit" class="btn btn-success mt-4">Save Purchase Order</button>
                <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary mt-4">Cancel</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.querySelector('#purchaseItemsTable tbody');
        const addItemButton = document.querySelector('#addItemButton');
        const grandTotalInput = document.querySelector('#grand_total');
        let itemIndex = 1;

        // নতুন সারি যোগ করার ফাংশন
        addItemButton.addEventListener('click', function () {
            const newRow = `
                <tr>
                    <td>
                        <select name="items[${itemIndex}][product_id]" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" required></td>
                    <td><input type="number" name="items[${itemIndex}][unit_price]" step="0.01" class="form-control unit_price" required></td>
                    <td><input type="number" name="items[${itemIndex}][total_price]" step="0.01" class="form-control total_price" readonly></td>
                    <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);
            itemIndex++;
        });

        // সারি অপসারণ এবং টোটাল আপডেট করার ফাংশন
        tableBody.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('tr').remove();
                updateGrandTotal();
            }
        });

        // টোটাল ক্যালকুলেট করার ফাংশন
        tableBody.addEventListener('input', function (e) {
            if (e.target.classList.contains('quantity') || e.target.classList.contains('unit_price')) {
                const row = e.target.closest('tr');
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit_price').value) || 0;
                const totalPriceInput = row.querySelector('.total_price');
                
                totalPriceInput.value = (quantity * unitPrice).toFixed(2);
                updateGrandTotal();
            }
        });
        
        // গ্র্যান্ড টোটাল আপডেট করার ফাংশন
        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.total_price').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            grandTotalInput.value = total.toFixed(2);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>