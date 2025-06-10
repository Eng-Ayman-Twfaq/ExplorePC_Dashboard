@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">إدارة الدفعات</h1>
        <a href="{{ route('payments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> إنشاء دفعة جديدة
        </a>
    </div>

    <!-- فلترة البيانات -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
        <form action="{{ route('payments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- فلترة حالة الدفع -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">حالة الدفع</label>
                <select name="status" id="status"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">جميع الحالات</option>
                    @foreach($statuses as $key => $status)
                        <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- فلترة طريقة الدفع -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">طريقة الدفع</label>
                <select name="payment_method" id="payment_method"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">جميع الطرق</option>
                    @foreach($paymentMethods as $key => $method)
                        <option value="{{ $key }}" {{ ($filters['payment_method'] ?? '') == $key ? 'selected' : '' }}>
                            {{ $method }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- فلترة التاريخ -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تاريخ الدفع</label>
                <input type="date" name="date" id="date" value="{{ $filters['date'] ?? '' }}"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- فلترة رقم الطلب -->
            <div>
                <label for="order_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">رقم الطلب</label>
                <input type="text" name="order_id" id="order_id" value="{{ $filters['order_id'] ?? '' }}"
                       class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                       placeholder="ابحث برقم الطلب">
            </div>

            <!-- أزرار الفلترة -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex-1 flex items-center justify-center">
                    <i class="fas fa-filter mr-2"></i> تطبيق الفلتر
                </button>
                @if(request()->hasAny(['status', 'payment_method', 'date', 'order_id']))
                    <a href="{{ route('payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-800 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">رقم الدفعة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">رقم الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">المبلغ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">طريقة الدفع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">تاريخ الدفع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @foreach($payments as $payment)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        #{{ $payment->paymentId }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        <a href="{{ route('orders.show', $payment->orderId) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400">
                            #{{ $payment->orderId }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ number_format($payment->amount, 2) }} $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        @if($payment->paymentMethod == 'wallet')
                            محفظة جوالي
                        @elseif($payment->paymentMethod == 'kareemy')
                            محفظة جيب الكريمي
                        @elseif($payment->paymentMethod == 'bank_transfer')
                            تحويل بنكي
                        @elseif($payment->paymentMethod == 'cash')
                            نقداً
                        @else
                            {{ $payment->paymentMethod }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $payment->paymentDate }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                'refunded' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                            ];
                            $statusTexts = [
                                'paid' => 'مدفوع',
                                'pending' => 'قيد الانتظار',
                                'failed' => 'فشل الدفع',
                                'refunded' => 'تم الاسترجاع'
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                            {{ $statusTexts[$payment->status] ?? $payment->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('payments.show', $payment->paymentId) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('payments.edit', $payment->paymentId) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('payments.destroy', $payment->paymentId) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('هل أنت متأكد من حذف هذه الدفعة؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->appends(request()->query())->links() }}
    </div>
</div>
@endsection
