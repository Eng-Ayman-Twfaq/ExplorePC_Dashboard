@extends('layouts.app')

@section('title', 'إنشاء سلة تسوق جديدة')
@section('header', 'إنشاء سلة تسوق')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <!-- عرض رسائل الخطأ -->
    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('carts.store') }}" method="POST" id="cart-form">
        @csrf

        <!-- قسم المستخدم -->
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                اختر المستخدم
            </label>
            <select name="user_id" id="user_id" required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                <option value="">-- اختر مستخدم --</option>
                @foreach($users as $user)
                <option value="{{ $user->UserId }}" {{ old('user_id') == $user->UserId ? 'selected' : '' }}>
                    {{ $user->UserName }} ({{ $user->email }})
                </option>
                @endforeach
            </select>
        </div>

        <!-- قسم المنتجات -->
        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">
                <i class="fas fa-laptop mr-2"></i> إضافة منتجات للسلة
            </h3>

            <div id="products-container">
                @if(old('products'))
                    @foreach(old('products') as $index => $product)
                    <div class="product-item mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
                                <select name="products[{{$index}}][product_id]" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white product-select">
                                    <option value="">-- اختر منتج --</option>
                                    @foreach($products as $productItem)
                                    <option value="{{ $productItem->productId }}"
                                            {{ $product['product_id'] == $productItem->productId ? 'selected' : '' }}>
                                        {{ $productItem->name }} ({{ number_format($productItem->price, 2) }} $)
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                                <input type="number" name="products[{{$index}}][quantity]" min="1"
                                       value="{{ $product['quantity'] ?? 1 }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white quantity-input">
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="remove-product px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- سيتم إضافة المنتج الأول تلقائياً عبر الجافاسكريبت -->
                @endif
            </div>

            <button type="button" id="add-product"
                    class="mt-2 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
                <i class="fas fa-plus mr-2"></i> إضافة منتج
            </button>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> إنشاء السلة
            </button>
        </div>
    </form>
</div>

<!-- قالب المنتج -->
<template id="product-template">
    <div class="product-item mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
                <select name="products[][product_id]" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white product-select">
                    <option value="">-- اختر منتج --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->productId }}">
                        {{ $product->name }} ({{ number_format($product->price, 2) }} $)
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                <input type="number" name="products[][quantity]" min="1" value="1" required
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white quantity-input">
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-product px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsContainer = document.getElementById('products-container');
    const addButton = document.getElementById('add-product');
    const productTemplate = document.getElementById('product-template');

    // إذا لم يكن هناك منتجات، نضيف واحداً تلقائياً
    if (document.querySelectorAll('.product-item').length === 0) {
        addProduct();
    }

    // حدث إضافة منتج جديد
    addButton.addEventListener('click', addProduct);

    // أحداث حذف المنتجات
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            if (document.querySelectorAll('.product-item').length > 1) {
                e.target.closest('.product-item').remove();
                updateIndexes();
            } else {
                alert('يجب أن تحتوي السلة على منتج واحد على الأقل');
            }
        }
    });

    function addProduct() {
        const clone = productTemplate.content.cloneNode(true);
        productsContainer.appendChild(clone);
        updateIndexes();
    }

    function updateIndexes() {
        document.querySelectorAll('.product-item').forEach((item, index) => {
            item.querySelectorAll('[name^="products"]').forEach(input => {
                const name = input.name.replace(/products\[\d*\]/, `products[${index}]`);
                input.name = name;
            });
        });
    }
});
</script>
@endpush
@endsection
