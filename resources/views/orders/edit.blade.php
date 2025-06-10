@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">تعديل الطلب #{{ $order->orderId }}</h1>

    <form action="{{ route('orders.update', $order->orderId) }}" method="POST" id="orderForm">
        @csrf
        @method('PUT')

        <!-- حقل مخفي لحفظ العناصر المحذوفة -->
        <input type="hidden" name="removed_items" id="removedItems" value="">

        <!-- معلومات الطلب الأساسية -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">معلومات الطلب</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- العميل -->
                <div class="mb-4">
                    <label for="UserId" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">العميل</label>
                    <select name="UserId" id="UserId" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->UserId }}" {{ $order->UserId == $customer->UserId ? 'selected' : '' }}>
                                {{ $customer->UserName }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- تاريخ الطلب -->
                <div class="mb-4">
                    <label for="orderDate" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">تاريخ الطلب</label>
                    <input type="date" name="orderDate" id="orderDate"
                           value="{{ old('orderDate', $order->orderDate) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- عنوان الشحن -->
                <div class="mb-4 md:col-span-2">
                    <label for="shippingAddress" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">عنوان الشحن</label>
                    <textarea name="shippingAddress" id="shippingAddress" rows="3"
                              class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>{{ old('shippingAddress', $order->shippingAddress) }}</textarea>
                </div>

                <!-- حالة الطلب -->
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">حالة الطلب</label>
                    <select name="status" id="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="قيد الانتظار" {{ $order->status == 'قيد الانتظار' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="قيد المعالجة" {{ $order->status == 'قيد المعالجة' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="مكتمل" {{ $order->status == 'مكتمل' ? 'selected' : '' }}>مكتمل</option>
                        <option value="ملغى" {{ $order->status == 'ملغى' ? 'selected' : '' }}>ملغى</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- عناصر الطلب (المنتجات) -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">المنتجات</h3>

            <div id="productsContainer">
                @foreach($order->items as $index => $item)
                <div class="product-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 border rounded-lg" data-item-id="{{ $item->orderItemId }}">
                    <input type="hidden" name="products[{{ $index }}][orderItemId]" value="{{ $item->orderItemId }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
                        <select name="products[{{ $index }}][productId]" class="product-select w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                            @foreach($products as $product)
                                <option value="{{ $product->productId }}"
                                        data-price="{{ $product->price }}"
                                        {{ $item->productId == $product->productId ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->price }} $)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                        <input type="number" name="products[{{ $index }}][quantity]" min="1"
                               value="{{ $item->quantity }}"
                               class="quantity-input w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر</label>
                        <input type="number" step="0.01" name="products[{{ $index }}][price]"
                               value="{{ $item->price }}"
                               class="price-input w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    </div>
                    <div class="flex items-end">
                        <button type="button" class="remove-product-btn bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" id="addProductBtn" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i> إضافة منتج
            </button>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('orders.show', $order->orderId) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                رجوع
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                حفظ التغييرات
            </button>
        </div>
    </form>
</div>

<!-- قالب JavaScript لحقل المنتج الجديد -->
<template id="newProductTemplate">
    <div class="product-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 border rounded-lg">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
            <select name="products[][productId]" class="product-select w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                <option value="">اختر منتجاً</option>
                @foreach($products as $product)
                    <option value="{{ $product->productId }}" data-price="{{ $product->price }}">
                        {{ $product->name }} ({{ $product->price }} $)
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
            <input type="number" name="products[][quantity]" min="1" value="1"
                   class="quantity-input w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر</label>
            <input type="number" step="0.01" name="products[][price]"
                   class="price-input w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
        </div>
        <div class="flex items-end">
            <button type="button" class="remove-product-btn bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
</template>
@php
    $productCount = $order->items->count() ?? 0;
@endphp
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('productsContainer');
    const addProductBtn = document.getElementById('addProductBtn');
    const newProductTemplate = document.getElementById('newProductTemplate');
    const removedItemsInput = document.getElementById('removedItems');
    let removedItems = [];
     let productCount = {{ $productCount }};
    // let productCount = {{ $order->items->count() }};

    // إضافة منتج جديد
    addProductBtn.addEventListener('click', function() {
        const newIndex = productCount++;
        const clone = newProductTemplate.content.cloneNode(true);

        // تحديث أسماء الحقول لتعكس الفهرس الجديد
        const htmlString = clone.firstElementChild.outerHTML
            .replace(/products\[\]\[/g, `products[${newIndex}][`);

        productsContainer.insertAdjacentHTML('beforeend', htmlString);
        const newProduct = productsContainer.lastElementChild;
        initProductEvents(newProduct);
    });

    // تهيئة أحداث المنتج
    function initProductEvents(productElement) {
        const select = productElement.querySelector('.product-select');
        const priceInput = productElement.querySelector('.price-input');
        const removeBtn = productElement.querySelector('.remove-product-btn');

        // تحديث السعر عند اختيار منتج
        if (select && priceInput) {
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    priceInput.value = selectedOption.getAttribute('data-price');
                }
            });
        }

        // حذف المنتج
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                const productItem = this.closest('.product-item');
                const itemId = productItem.dataset.itemId;

                if (itemId) {
                    // إذا كان عنصراً موجوداً (ليس جديداً)، نضيفه إلى قائمة المحذوفات
                    removedItems.push(itemId);
                    removedItemsInput.value = JSON.stringify(removedItems);
                }

                // التأكد من بقاء منتج واحد على الأقل
                if (document.querySelectorAll('.product-item').length > 1) {
                    productItem.remove();
                    reindexProducts();
                } else {
                    alert('يجب أن يحتوي الطلب على منتج واحد على الأقل');
                }
            });
        }
    }

    // إعادة ترقيم المنتجات بعد الحذف
    function reindexProducts() {
        const products = document.querySelectorAll('.product-item:not([data-item-id])');
        products.forEach((product, index) => {
            // تحديث أسماء الحقول للمنتجات الجديدة فقط
            const inputs = product.querySelectorAll('[name^="products["]');
            inputs.forEach(input => {
                input.name = input.name.replace(/products\[\d+\]/, `products[${index}]`);
            });
        });
    }

    // تهيئة أحداث لجميع المنتجات الموجودة
    document.querySelectorAll('.product-item').forEach(initProductEvents);
});
</script>
@endsection
