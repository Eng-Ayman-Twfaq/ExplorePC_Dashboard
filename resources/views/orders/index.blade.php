@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">إدارة الطلبات</h1>
        <a href="{{ route('orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> إنشاء طلب جديد
        </a>
    </div>

    <!-- فلترة البيانات -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- حقل الحالة -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">حالة الطلب</label>
                <select name="status" id="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">جميع الحالات</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ urldecode(request('status')) == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- حقل التاريخ -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تاريخ الطلب</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
<!-- فلترة العميل -->
<div>
    <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">العميل</label>
    <select name="customer_id" id="customer_id" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">جميع العملاء</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->UserId }}" {{ request('customer_id') == $customer->UserId ? 'selected' : '' }}>
                {{ $customer->UserName }}
            </option>
        @endforeach
    </select>
</div>

<!-- فلترة المنتج -->
<div>
    <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المنتج</label>
    <select name="product_id" id="product_id" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="">جميع المنتجات</option>
        @foreach($products as $product)
            <option value="{{ $product->productId }}" {{ request('product_id') == $product->productId ? 'selected' : '' }}>
                {{ $product->name }}
            </option>
        @endforeach
    </select>
</div>
</div>
            <!-- أزرار الفلترة -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex-1">
                    <i class="fas fa-filter mr-2"></i> فلترة
                </button>
                @if(request()->hasAny(['status', 'date']))
                    <a href="{{ route('orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-800 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">رقم الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">العميل</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">التاريخ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">المبلغ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">المنتجات</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        #{{ $order->orderId }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->customer->UserName ?? 'غير معروف' }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->shippingAddress }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $order->orderDate }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ number_format($order->totalAmount, 2) }} $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'قيد الانتظار' => 'bg-yellow-100 text-yellow-800',
                                'قيد المعالجة' => 'bg-blue-100 text-blue-800',
                                'مكتمل' => 'bg-green-100 text-green-800',
                                'ملغى' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ __($order->status) }}
                        </span>
                    </td>
                    <!-- داخل حلقة العرض -->
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
    {{ $order->items->count() }} منتج
</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('orders.show', $order->orderId) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('orders.edit', $order->orderId) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('orders.destroy', $order->orderId) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="mt-4">
        {{ $orders->appends(request()->query())->links() }}
    </div> --}}
</div>
@endsection
