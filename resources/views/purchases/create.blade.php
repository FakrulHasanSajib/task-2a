<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Create</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
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
        /* Style for the alert box */
        .alert-box {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            padding: 1rem;
            border-radius: 0.5rem;
            color: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            animation: slideIn 0.5s forwards;
        }
        .alert-box.success {
            background-color: #10B981; /* Green */
        }
        .alert-box.error {
            background-color: #EF4444; /* Red */
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Purchase Create</h1>

        <!-- Session messages will be displayed here -->
        @if(session('success'))
            <div class="alert-box success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-box error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Product Information -->
                <div class="md:col-span-2">
                    <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                        <h2 class="text-lg font-semibold mb-4">Product Information</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Product<span class="text-red-500">*</span></label>
                                <select id="product_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Search Name of Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-unit-price="{{ $product->unit_price ?? 0 }}" data-brand-id="{{ $product->brand_id }}" data-category-id="{{ $product->category_id }}" data-unit-id="{{ $product->unit_id }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Qty<span class="text-red-500">*</span></label>
                                <input type="number" id="quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Qty">
                            </div>
                            <div>
                                <label for="unit_price" class="block text-gray-700 text-sm font-bold mb-2">Unit Price<span class="text-red-500">*</span></label>
                                <input type="number" id="unit_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Unit Price">
                            </div>
                            <div class="flex items-end">
                                <button type="button" id="addProductBtn" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded w-full">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table id="productTable" class="w-full table-auto text-left">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-2 px-4">S/L</th>
                                        <th class="py-2 px-4">Item Details</th>
                                        <th class="py-2 px-4">Qty</th>
                                        <th class="py-2 px-4">Unit Price</th>
                                        <th class="py-2 px-4">Total Price</th>
                                        <th class="py-2 px-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="tempRow" class="bg-gray-100 hidden">
                                        <td class="py-2 px-4">#</td>
                                        <td id="tempItemDetails" class="py-2 px-4"></td>
                                        <td id="tempQty" class="py-2 px-4"></td>
                                        <td id="tempUnitPrice" class="py-2 px-4"></td>
                                        <td id="tempTotalPrice" class="py-2 px-4"></td>
                                        <td class="py-2 px-4"></td>
                                    </tr>
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right font-bold">Total</td>
                                        <td id="totalQty" class="font-bold">0</td>
                                        <td></td>
                                        <td id="grandTotal" class="font-bold">0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input type="hidden" name="products" id="productsInput">
                    </div>
                </div>

                <!-- Other Information -->
                <div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                        <h2 class="text-lg font-semibold mb-4">Other Information</h2>
                        
                        <!-- Date Field -->
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date<span class="text-red-500">*</span></label>
                            <input type="date" id="date" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        
                        <!-- Supplier Field -->
                        <div class="mb-4">
                            <label for="supplier_id" class="block text-gray-700 text-sm font-bold mb-2">Supplier<span class="text-red-500">*</span></label>
                            <select id="supplier_id" name="supplier_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="">Search Name of Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Notes Field -->
                        <div class="mb-4">
                            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                            <textarea id="notes" name="notes" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter Notes"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-start items-center mt-6 space-x-4">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save
                </button>
                <a href="{{ route('purchases.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('purchaseForm');
            const addProductBtn = document.getElementById('addProductBtn');
            const productTableBody = document.querySelector('#productTable tbody');
            const totalQtyElement = document.getElementById('totalQty');
            const grandTotalElement = document.getElementById('grandTotal');
            const productsInput = document.getElementById('productsInput');
            const productSelect = document.getElementById('product_id');
            const qtyInput = document.getElementById('quantity');
            const unitPriceInput = document.getElementById('unit_price');
            const tempRow = document.getElementById('tempRow');
            const tempItemDetails = document.getElementById('tempItemDetails');
            const tempQty = document.getElementById('tempQty');
            const tempUnitPrice = document.getElementById('tempUnitPrice');
            const tempTotalPrice = document.getElementById('tempTotalPrice');

            let items = [];

            function updateTempRow() {
                const productId = productSelect.value;
                const productName = productSelect.options[productSelect.selectedIndex].text;
                const quantity = parseFloat(qtyInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const total = quantity * unitPrice;

                if (productId && quantity > 0 && unitPrice > 0) {
                    tempItemDetails.textContent = productName;
                    tempQty.textContent = quantity;
                    tempUnitPrice.textContent = unitPrice;
                    tempTotalPrice.textContent = total.toFixed(2);
                    tempRow.classList.remove('hidden');
                } else {
                    tempRow.classList.add('hidden');
                }
            }

            // Update unit price and temporary row on product selection
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const unitPrice = selectedOption.dataset.unitPrice;
                unitPriceInput.value = unitPrice;
                updateTempRow();
            });

            // Update temporary row on quantity or unit price change
            qtyInput.addEventListener('input', updateTempRow);
            unitPriceInput.addEventListener('input', updateTempRow);

            // Add new product row
            addProductBtn.addEventListener('click', function () {
                const productId = productSelect.value;
                const productName = productSelect.options[productSelect.selectedIndex].text;
                const quantity = qtyInput.value;
                const unitPrice = unitPriceInput.value;

                if (!productId || !quantity || !unitPrice || quantity <= 0 || unitPrice <= 0) {
                    alert('অনুগ্রহ করে পণ্যের সকল ক্ষেত্র সঠিকভাবে পূরণ করুন।');
                    return;
                }

                const total = parseFloat(quantity) * parseFloat(unitPrice);
                
                const item = {
                    product_id: productId,
                    name: productName,
                    quantity: parseFloat(quantity),
                    unit_price: parseFloat(unitPrice),
                    total_price: total,
                };
                items.push(item);
                
                renderTable();
                
                // Clear input fields and hide temporary row
                productSelect.value = '';
                qtyInput.value = '';
                unitPriceInput.value = '';
                tempRow.classList.add('hidden');
            });

            // Render table from items array
            function renderTable() {
                // Clear all but the temporary row
                const permanentRows = productTableBody.querySelectorAll('tr:not(#tempRow)');
                permanentRows.forEach(row => row.remove());
                
                let totalQty = 0;
                let grandTotal = 0;
                
                items.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-2 px-4">${index + 1}</td>
                        <td class="py-2 px-4">${item.name}</td>
                        <td class="py-2 px-4">${item.quantity}</td>
                        <td class="py-2 px-4">${item.unit_price}</td>
                        <td class="py-2 px-4">${item.total_price.toFixed(2)}</td>
                        <td class="py-2 px-4">
                            <button type="button" class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-md delete-btn" data-index="${index}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v2M8 7h8" />
                                </svg>
                            </button>
                        </td>
                    `;
                    productTableBody.insertBefore(row, tempRow);
                    totalQty += item.quantity;
                    grandTotal += item.total_price;
                });
                
                totalQtyElement.textContent = totalQty;
                grandTotalElement.textContent = grandTotal.toFixed(2);

                // Update hidden input for form submission
                productsInput.value = JSON.stringify(items);
            }
            
            // Delete product row
            productTableBody.addEventListener('click', function(e) {
                if (e.target.closest('.delete-btn')) {
                    const index = e.target.closest('.delete-btn').dataset.index;
                    items.splice(index, 1);
                    renderTable();
                }
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                if (items.length === 0) {
                    e.preventDefault();
                    alert('অনুগ্রহ করে কমপক্ষে একটি পণ্য যোগ করুন।');
                }
            });
        });
    </script>
</body>
</html>

