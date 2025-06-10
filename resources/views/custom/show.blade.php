@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تفاصيل العميل</h1>
        <div class="flex space-x-3">
            <a href="{{ route('custom.edit', $custom->UserId) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-edit mr-2"></i> تعديل
            </a>
            <a href="{{ route('custom.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> رجوع
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden transition-all duration-300">
        <div class="md:flex">
            <!-- صورة العميل -->
            <div class="md:w-1/3 p-6 flex items-center justify-center bg-gray-100 dark:bg-gray-700">
                @if($custom->Image)
                    <img src="{{ asset('storage/' . $custom->Image) }}" alt="{{ $custom->UserName }}" class="w-full h-auto max-h-96 object-contain rounded-lg hover:scale-105 transition-transform">
                @else
                    <div class="w-full h-64 bg-gray-200 dark:bg-gray-600 flex items-center justify-center rounded-lg">
                        <i class="fas fa-user text-gray-400 dark:text-gray-300 text-6xl"></i>
                    </div>
                @endif
            </div>

            <!-- تفاصيل العميل -->
            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $custom->UserName }}</h2>
                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-3 py-1 rounded-full">
                        #{{ $custom->UserId }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">البريد الإلكتروني</p>
                        <p class="text-blue-600 dark:text-blue-400 font-medium">
                            <a href="mailto:{{ $custom->email }}" class="hover:underline">{{ $custom->email }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">رقم الهاتف</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">
                            <a href="tel:+966{{ $custom->Phone }}" class="hover:underline">+966 {{ $custom->Phone }}</a>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">تاريخ التسجيل</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">
                            {{ $custom->created_at->format('Y-m-d') }}
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $custom->created_at->diffForHumans() }})</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">آخر تحديث</p>
                        <p class="text-gray-800 dark:text-gray-200 font-medium">
                            {{ $custom->updated_at->format('Y-m-d') }}
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ $custom->updated_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">العنوان</p>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                        <p class="text-gray-800 dark:text-gray-200">{{ $custom->Address }}</p>
                    </div>
                </div>

                <!-- إحصائيات إضافية (اختياري) -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">نشاط العميل</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">عدد الطلبات</p>
                            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">15</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/30 p-3 rounded-lg text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">إجمالي المشتريات</p>
                            <p class="text-xl font-bold text-green-600 dark:text-green-400">2,450 $</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/30 p-3 rounded-lg text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">آخر طلب</p>
                            <p class="text-xl font-bold text-purple-600 dark:text-purple-400">قيد التوصيل</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/30 p-3 rounded-lg text-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400">مستوى الولاء</p>
                            <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400">ذهبي</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
