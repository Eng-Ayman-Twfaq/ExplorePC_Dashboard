@extends('layouts.app')

@section('title', 'تفاصيل سلة التسوق')
@section('header', 'تفاصيل سلة التسوق')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                <i class="fas fa-shopping-cart mr-2"></i> تفاصيل السلة #{{ $cart->cartId }}
            </h2>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                {{ $cart->created_at->diffForHumans() }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="font-medium text-gray-800 dark:text-white mb-2">
                    <i class="fas fa-user mr-2"></i> معلومات المستخدم
                </h3>
                <div class="space-y-2">
                    <p><span class="font-medium">الاسم:</span> {{ $cart->customer->UserName }}</p>
                    <p><span class="font-medium">البريد:</span> {{ $cart->customer->email }}</p>
                    <p><span class="font-medium">الهاتف:</span> {{ $cart->customer->Phone }}</p>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                <h3 class="font-medium text-gray-800 dark:text-white mb-2">
                    <i class="fas fa-info-circle mr-2"></i> ملخص السلة
                </h3>
                <div class="space-y-2">
                    <p><span class="font-medium">عدد المنتجات:</span> {{ $cart->items->count() }}</p>
                    <p><span class="font-medium">إجمالي القطع:</span> {{ $cart->items->sum('quantity') }}</p>
                    <p><span class="font-medium">المجموع الكلي:</span> {{ number_format($total, 2) }} $</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">المنتج</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">السعر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الكمية</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">المجموع</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($cart->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded object-cover"
                                         src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('images/default-product.png') }}"
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="mr-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item->product->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->product->category }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ number_format($item->product->price, 2) }} $
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ number_format($item->product->price * $item->quantity, 2) }} $
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">
                            المجموع الكلي:
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($total, 2) }} $
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('carts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i> رجوع للقائمة
            </a>
        </div>
    </div>
</div>
@endsection
