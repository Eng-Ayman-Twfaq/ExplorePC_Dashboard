@extends('layouts.app')

@section('title', 'تعديل سلة التسوق')
@section('header', 'تعديل سلة التسوق')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <!-- معلومات المستخدم (للعرض فقط) -->
    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
        <h3 class="font-medium text-gray-800 dark:text-white mb-3">
            <i class="fas fa-user-circle mr-2"></i> معلومات صاحب السلة
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">الاسم:</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cart->customer->UserName }}</p>
            </div>
            {{-- <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">البريد:</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cart->user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">الهاتف:</p>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $cart->user->Phone }}</p>
            </div> --}}
        </div>
    </div>

    <!-- تفاصيل السلة -->
    <form action="{{ route('carts.update', $cart->cartId) }}" method="POST" id="cart-form">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">
                <i class="fas fa-shopping-cart mr-2"></i> المنتجات في السلة
            </h3>

            <div id="products-container">
                @foreach($cart->items as $index => $item)
                <div class="product-item mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <input type="hidden" name="products[{{$index}}][id]" value="{{ $item->cart_item_id }}">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
                            <select name="products[{{$index}}][product_id]" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">-- اختر منتج --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->productId }}"
                                        {{ $item->product_id == $product->productId ? 'selected' : '' }}
                                        data-price="{{ $product->price }}">
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                            <input type="number" name="products[{{$index}}][quantity]" min="1"
                                   value="{{ $item->quantity }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر</label>
                            <p class="text-sm text-gray-900 dark:text-white product-price">
                                {{ number_format($item->product->price, 2) }} $
                            </p>
                        </div>
                        <div class="flex items-end">
                            <button type="button" class="remove-product px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" id="add-product"
                    class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 dark:bg-gray-700 dark:text-white">
                <i class="fas fa-plus mr-2"></i> إضافة منتج جديد
            </button>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('carts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                <i class="fas fa-times mr-2"></i> إلغاء
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> حفظ التعديلات
            </button>
        </div>
    </form>
</div>

<!-- قالب المنتج الجديد -->
<template id="product-template">
    <div class="product-item mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
                <select name="products[][product_id]" required
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white product-select">
                    <option value="">-- اختر منتج --</option>
                    @foreach($products as $product)
                    <option value="{{ $product->productId }}" data-price="{{ $product->price }}">
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية</label>
                <input type="number" name="products[][quantity]" min="1" value="1" required
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر</label>
                <p class="text-sm text-gray-900 dark:text-white product-price">0.00 $</p>
            </div>
            <div class="flex items-end">
                <button type="button" class="remove-product px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </div>
        </div>
    </div>
</template>
@php
    $itemCount = is_countable($cart->items ?? []) ? count($cart->items) : 0;
@endphp
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('products-container');
    const addBtn = document.getElementById('add-product');
    const template = document.getElementById('product-template');
    let index = { $itemCount };
    console.log('عدد المنتجات:', index);
    // let index = {{ count($cart->items) }};
// let index = @json(count($cart->items));
    // تحديث السعر عند تغيير المنتج
    container.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const price = e.target.selectedOptions[0].dataset.price;
            const priceElement = e.target.closest('.grid').querySelector('.product-price');
            priceElement.textContent = parseFloat(price).toFixed(2) + ' $';
        }
    });

    // إضافة منتج جديد
    addBtn.addEventListener('click', function() {
        const clone = template.content.cloneNode(true);
        const newItem = clone.querySelector('.product-item');

        // تحديث الأسماء والفهارس
        clone.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace('[]', `[${index}]`);
        });

        container.appendChild(clone);
        index++;
    });

    // حذف منتج
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-product')) {
            const item = e.target.closest('.product-item');
            if (container.querySelectorAll('.product-item').length > 1) {
                item.remove();
            } else {
                alert('يجب أن تحتوي السلة على منتج واحد على الأقل');
            }
        }
    });
});
</script>
@endpush
@endsection
