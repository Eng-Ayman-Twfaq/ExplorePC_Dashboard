@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">تفاصيل الدفعة #{{ $payment->paymentId }}</h1>
        <a href="{{ route('payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            رجوع للقائمة
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- معلومات الدفعة -->
            <div class="space-y-4">
                <div class="border-b pb-4">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">معلومات الدفعة</h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">رقم الدفعة</p>
                        <p class="font-medium dark:text-white">#{{ $payment->paymentId }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">رقم الطلب</p>
                        <a href="{{ route('orders.show', $payment->orderId) }}" class="font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            #{{ $payment->orderId }}
                        </a>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">المبلغ</p>
                        <p class="font-medium dark:text-white">{{ number_format($payment->amount, 2) }} $</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">طريقة الدفع</p>
                        <p class="font-medium dark:text-white">
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
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ الدفع</p>
                        <p class="font-medium dark:text-white">{{ $payment->paymentDate }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">حالة الدفع</p>
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
                    </div>
                </div>
            </div>

            <!-- معلومات إضافية -->
            <div class="space-y-4">
                <div class="border-b pb-4">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">معلومات إضافية</h2>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ الإنشاء</p>
                    <p class="font-medium dark:text-white">{{ $payment->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">آخر تحديث</p>
                    <p class="font-medium dark:text-white">{{ $payment->updated_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-end space-x-3">
            <a href="{{ route('payments.edit', $payment->paymentId) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-edit mr-2"></i> تعديل
            </a>
            <form action="{{ route('payments.destroy', $payment->paymentId) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center" onclick="return confirm('هل أنت متأكد من حذف هذه الدفعة؟')">
                    <i class="fas fa-trash mr-2"></i> حذف
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
