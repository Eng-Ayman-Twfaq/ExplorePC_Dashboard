@extends('layouts.app')

{{-- @section('title', 'سلات التسوق') --}}
@section('header', 'إدارة سلات التسوق')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <!-- رسائل التنبيه -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            <i class="fas fa-shopping-cart mr-2"></i> جميع سلات التسوق
        </h2>
        <a href="{{ route('carts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> إنشاء سلة جديدة
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">رقم السلة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">المستخدم</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">عدد المنتجات</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">تاريخ الإنشاء</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($carts as $cart)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        #{{ $cart->cartId }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $cart->customer->UserName ?? 'غير معروف' }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $cart->customer->email ?? '---' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $cart->items->count() }} منتجات
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $cart->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('carts.edit', $cart->cartId) }}"
                           class="text-yellow-600 hover:text-yellow-900"
                           title="تعديل">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="{{ route('carts.show', $cart->cartId) }}"
                           class="text-blue-600 hover:text-blue-900"
                           title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>

                        <form action="{{ route('carts.destroy', $cart->cartId) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-900"
                                    title="حذف"
                                    onclick="return confirm('هل أنت متأكد من حذف هذه السلة؟')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $carts->links() }}
    </div>
</div>
@endsection
