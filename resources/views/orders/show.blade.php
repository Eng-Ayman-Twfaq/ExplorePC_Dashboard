@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">تفاصيل الطلب #{{ $order->orderId }}</h1>
        <div class="flex space-x-3">
            <a href="{{ route('orders.edit', $order->orderId) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> تعديل
            </a>
            <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> رجوع
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 p-6 border-r dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">معلومات العميل</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">اسم العميل</p>
                        <p class="text-gray-800 dark:text-gray-200">{{ $order->customer->UserName ?? 'غير معروف' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">البريد الإلكتروني</p>
                        <p class="text-blue-600 dark:text-blue-400">{{ $order->customer->email ?? 'غير معروف' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">رقم الهاتف</p>
                        <p class="text-gray-800 dark:text-gray-200">{{ $order->customer->Phone ?? 'غير معروف' }}</p>
                    </div>
                </div>
            </div>

            <div class="md:w-2/3 p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">تفاصيل الطلب</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">تاريخ الطلب</p>
                        <p class="text-gray-800 dark:text-gray-200">{{ $order->orderDate }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">المبلغ الإجمالي</p>
                        <p class="text-green-600 dark:text-green-400 font-bold">{{ number_format($order->totalAmount, 2) }} $</p>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">حالة الطلب</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ __($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">تاريخ الإنشاء</p>
                        <p class="text-gray-800 dark:text-gray-200">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">عنوان الشحن</p>
                    <p class="text-gray-800 dark:text-gray-200">{{ $order->shippingAddress }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ... (الأجزاء السابقة) ... -->

<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">المنتجات المطلوبة</h3>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">المنتج</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">السعر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">الكمية</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">المجموع</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($order->items as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-10 w-10 rounded-full object-cover mr-3">
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->product->category }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ number_format($item->price, 2) }} $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $item->quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ number_format($item->price * $item->quantity, 2) }} $
                    </td>
                </tr>
                @endforeach
                <tr class="bg-gray-50 dark:bg-gray-700 font-bold">
                    <td colspan="3" class="px-6 py-4 text-right text-sm text-gray-800 dark:text-gray-200">المجموع الكلي</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        {{ number_format($order->totalAmount, 2) }} $
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
