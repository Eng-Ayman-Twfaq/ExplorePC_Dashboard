@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">تعديل الدفعة #{{ $payment->paymentId }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('payments.show', $payment->paymentId) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-eye mr-2"></i> عرض التفاصيل
            </a>
            <a href="{{ route('payments.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-list mr-2"></i> رجوع للقائمة
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ route('payments.update', $payment->paymentId) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- حقل رقم الطلب -->
                <div>
                    <label for="orderId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">رقم الطلب</label>
                    <select name="orderId" id="orderId" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        @foreach($orders as $order)
                            <option value="{{ $order->orderId }}" {{ $payment->orderId == $order->orderId ? 'selected' : '' }}>
                                #{{ $order->orderId }} - {{ number_format($order->totalAmount, 2) }} $
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- حقل المبلغ -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">المبلغ ($)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <!-- حقل طريقة الدفع -->
                <div>
                    <label for="paymentMethod" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">طريقة الدفع</label>
                    <select name="paymentMethod" id="paymentMethod" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="wallet" {{ $payment->paymentMethod == 'wallet' ? 'selected' : '' }}>محفظة جوالي</option>
                        <option value="kareemy" {{ $payment->paymentMethod == 'kareemy' ? 'selected' : '' }}>محفظة جيب الكريمي</option>
                        <option value="bank_transfer" {{ $payment->paymentMethod == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                        <option value="cash" {{ $payment->paymentMethod == 'cash' ? 'selected' : '' }}>نقداً</option>
                    </select>
                </div>

                <!-- حقل حالة الدفع -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">حالة الدفع</label>
                    <select name="status" id="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>مدفوع</option>
                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>فشل الدفع</option>
                        <option value="refunded" {{ $payment->status == 'refunded' ? 'selected' : '' }}>تم الاسترجاع</option>
                    </select>
                </div>

                <!-- حقل تاريخ الدفع -->
                <div>
                    <label for="paymentDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">تاريخ الدفع</label>
                    <input type="date" name="paymentDate" id="paymentDate" value="{{ old('paymentDate', $payment->paymentDate) }}"
                           class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
            </div>

            <!-- رسائل الخطأ -->
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 dark:bg-red-900 dark:border-red-700 dark:text-red-100">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- أزرار الحفظ -->
            <div class="flex justify-end space-x-3 border-t pt-6 dark:border-gray-700">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-save mr-2"></i> حفظ التعديلات
                </button>
                <a href="{{ route('payments.show', $payment->paymentId) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
