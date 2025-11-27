<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Page</title>
    @vite('resources/css/app.css') <!-- Import Tailwind CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-900 text-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-gray-800 shadow-sm border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-lg lg:text-xl font-semibold text-white">Aberp Sales</h1>
                </div>
                <div class="flex items-center space-x-2 lg:space-x-4">
                    <span class="text-gray-300 text-sm lg:text-base">Welcome, {{ Auth::user()->name }}</span>
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-emerald-400 hover:text-emerald-300 text-sm lg:text-base">Admin Dashboard</a>
                    @else
                        <a href="{{ route('sales.dashboard') }}"
                            class="text-emerald-400 hover:text-emerald-300 text-sm lg:text-base">Sales Dashboard</a>
                    @endif
                    <a href="{{ route('login') }}"
                        class="text-gray-300 hover:text-white text-sm lg:text-base">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex items-center justify-center min-h-screen py-4 lg:py-8 px-4">
        <div
            class="w-full max-w-2xl mx-auto p-4 lg:p-6 space-y-6 bg-gray-800 shadow-lg rounded-lg border border-gray-700">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="bg-green-900 border border-green-600 text-green-200 px-4 py-3 rounded mb-4 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                        <button type="button" class="close-message text-green-300 hover:text-green-100"
                            onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-900 border border-red-600 text-red-200 px-4 py-3 rounded mb-4 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                        <button type="button" class="close-message text-red-300 hover:text-red-100"
                            onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="bg-yellow-900 border border-yellow-600 text-yellow-200 px-4 py-3 rounded mb-4 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('warning') }}
                        </div>
                        <button type="button" class="close-message text-yellow-300 hover:text-yellow-100"
                            onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="bg-blue-900 border border-blue-600 text-blue-200 px-4 py-3 rounded mb-4 relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ session('info') }}
                        </div>
                        <button type="button" class="close-message text-blue-300 hover:text-blue-100"
                            onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div
                class="flex flex-col lg:flex-row w-full justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <h2 class="text-lg lg:text-xl font-semibold text-white">Make a Sale</h2>
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('admin.categories.create') }}"
                        class="bg-emerald-600 text-white px-4 py-2 rounded hover:bg-emerald-700 transition-colors">
                        + Category
                    </a>
                @endif
            </div>
            <form action="{{ route('sale.post') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                <div id="sale-items">
                    <!-- Sale Item Row -->
                    <div class="sale-row border border-gray-600 p-4 mb-4 rounded shadow bg-gray-700">
                        <!-- Category -->
                        <label class="text-gray-200 font-medium">Category</label>
                        <select name="category[]"
                            class="category w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <!-- Subcategory -->
                        <label class="mt-2 block text-gray-200 font-medium">Sub-category</label>
                        <select name="brand[]"
                            class="brand w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Subcategory</option>
                        </select>

                        <!-- Spec -->
                        <label class="mt-2 block text-gray-200 font-medium">Model / Size / Volume</label>
                        <select name="spec[]"
                            class="spec w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Spec</option>
                        </select>

                        <!-- Product -->
                        <label class="mt-2 block text-gray-200 font-medium">Product</label>
                        <select name="product[]"
                            class="product w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Product</option>
                        </select>

                        <!-- Quantity & Price -->
                        <!-- Quantity & Payment Breakdown -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                            <div class="md:col-span-1">
                                <label class="text-gray-200 font-medium">Quantity</label>
                                <input type="number" name="quantity[]"
                                    class="w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    min="1" value="1">
                            </div>
                            <div class="md:col-span-1">
                                <label class="text-gray-200 font-medium">Cash</label>
                                <input type="number" name="cash_transfer[]"
                                    class="w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    min="0" step="0.01" value="0">
                            </div>
                            <div class="md:col-span-1">
                                <label class="text-gray-200 font-medium">Bank</label>
                                <input type="number" name="bank_transfer[]"
                                    class="w-full mt-1 p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    min="0" step="0.01" value="0">
                            </div>
                        </div>

                        <!-- Remove Button -->
                        <button type="button" class="remove-row mt-3 text-red-600">Remove</button>
                    </div>
                </div>

                <!-- Add Row Button -->
                <button type="button" id="add-row" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add
                    Item</button>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full mt-4 bg-emerald-600 text-white p-2 rounded hover:bg-emerald-700 transition-colors">
                    Confirm Sale
                </button>
            </form>

        </div>

        <script>
            const allSubCategories = @json($subCategories);
            const allSpecs = @json($specs);
            const allProducts = @json($products);

            document.addEventListener('DOMContentLoaded', function() {
                const saleItems = document.getElementById('sale-items');
                const addRowBtn = document.getElementById('add-row');

                // Add new sale row
                addRowBtn.addEventListener('click', () => {
                    const firstRow = saleItems.querySelector('.sale-row');
                    const newRow = firstRow.cloneNode(true);

                    // Reset all values in cloned row
                    newRow.querySelectorAll('select, input').forEach(el => {
                        el.value = '';
                    });
                    
                    // Clear options for dependent selects
                    newRow.querySelector('.brand').innerHTML = '<option value="">Select Subcategory</option>';
                    newRow.querySelector('.spec').innerHTML = '<option value="">Select Spec</option>';
                    newRow.querySelector('.product').innerHTML = '<option value="">Select Product</option>';

                    saleItems.appendChild(newRow);
                    attachEventsToRow(newRow);
                });

                // Attach remove event and dropdown handlers
                function attachEventsToRow(row) {
                    row.querySelector('.remove-row').addEventListener('click', () => {
                        if (saleItems.querySelectorAll('.sale-row').length > 1) {
                            row.remove();
                        }
                    });

                    const category = row.querySelector('.category');
                    const brand = row.querySelector('.brand');
                    const spec = row.querySelector('.spec');
                    const product = row.querySelector('.product');

                    category.addEventListener('change', function() {
                        const categoryId = this.value;
                        
                        // Filter Subcategories
                        const filteredSubCats = allSubCategories.filter(item => item.category_id == categoryId);
                        brand.innerHTML = '<option value="">Select Subcategory</option>';
                        filteredSubCats.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.name;
                            brand.appendChild(opt);
                        });

                        // Filter Specs (where sub_category_id is null)
                        const filteredSpecs = allSpecs.filter(item => item.category_id == categoryId && !item.sub_category_id);
                        spec.innerHTML = '<option value="">Select Spec</option>';
                        filteredSpecs.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.name;
                            spec.appendChild(opt);
                        });
                        
                        // Clear Product
                        product.innerHTML = '<option value="">Select Product</option>';
                    });

                    brand.addEventListener('change', function() {
                        const subCatId = this.value;
                        const categoryId = category.value;

                        let filteredSpecs = [];
                        if (subCatId) {
                             filteredSpecs = allSpecs.filter(item => item.sub_category_id == subCatId);
                        } else {
                             // Revert to category only if subcategory is deselected
                             filteredSpecs = allSpecs.filter(item => item.category_id == categoryId && !item.sub_category_id);
                        }

                        spec.innerHTML = '<option value="">Select Spec</option>';
                        filteredSpecs.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.name;
                            spec.appendChild(opt);
                        });
                        
                        // Clear Product
                        product.innerHTML = '<option value="">Select Product</option>';
                    });

                    spec.addEventListener('change', function() {
                        const attrId = this.value; // spec_id
                        const categoryId = category.value;
                        const subCatId = brand.value;

                        const filteredProducts = allProducts.filter(item => {
                            let match = true;
                            if (attrId) match = match && (item.spec_id == attrId);
                            if (categoryId) match = match && (item.category_id == categoryId);
                            if (subCatId) match = match && (item.sub_category_id == subCatId);
                            return match;
                        });

                        product.innerHTML = '<option value="">Select Product</option>';
                        filteredProducts.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.id;
                            opt.text = item.name;
                            product.appendChild(opt);
                        });
                    });
                }

                // Initialize first row
                saleItems.querySelectorAll('.sale-row').forEach(row => attachEventsToRow(row));
            });

            // Auto-hide session messages after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const messages = document.querySelectorAll(
                    '[class*="bg-green-900"], [class*="bg-red-900"], [class*="bg-yellow-900"], [class*="bg-blue-900"]'
                    );
                messages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.transition = 'opacity 0.5s ease-out';
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.remove();
                        }, 500);
                    }, 5000);
                });
            });
        </script>

    </div>
    </div>
</body>

</html>
