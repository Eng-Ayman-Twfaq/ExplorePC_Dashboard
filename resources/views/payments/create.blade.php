@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">إنشاء دفعة جديدة</h1>
        <a href="{{ route('payments.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            رجوع
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- حقل رقم الطلب -->
                <div>
                    <label for="orderId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">رقم الطلب</label>
                    <select name="orderId" id="orderId" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">اختر الطلب</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->orderId }}">
                                #{{ $order->orderId}} - ( {{ number_format($order->totalAmount, 2)  }})  {{$order->customer->UserName  }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- حقل المبلغ -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المبلغ</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- حقل طريقة الدفع -->
                <div>
                    <label for="paymentMethod" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">طريقة الدفع</label>
                    <select name="paymentMethod" id="paymentMethod" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="wallet">محفظة جوالي</option>
                        <option value="kareemy">محفظة جيب الكريمي</option>
                        <option value="bank_transfer">تحويل بنكي</option>
                        <option value="cash">نقداً</option>
                    </select>
                </div>

                <!-- حقل حالة الدفع -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">حالة الدفع</label>
                    <select name="status" id="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="paid">مدفوع</option>
                        <option value="pending">قيد الانتظار</option>
                        <option value="failed">فشل الدفع</option>
                    </select>
                </div>

                <!-- حقل تاريخ الدفع -->
                <div>
                    <label for="paymentDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تاريخ الدفع</label>
                    <input type="date" name="paymentDate" id="paymentDate" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i> حفظ الدفعة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
