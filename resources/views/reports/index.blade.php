@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">التقارير</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- تقرير المبيعات اليومية -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-3">
                    <i class="fas fa-shopping-bag text-blue-600 dark:text-blue-300 text-xl"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">تقرير المبيعات اليومية</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-4">عرض إحصائيات المبيعات حسب التاريخ</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('reports.daily') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-eye mr-2"></i> عرض التقرير
                </a>
                <a href="{{ route('reports.download') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-download mr-2"></i> تحميل PDF
                </a>
            </div>
        </div>

        <!-- تقرير المنتجات شبه المنتهية -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-red-100 dark:bg-red-900 p-3 rounded-full mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-300 text-xl"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">تقرير المنتجات شبه المنتهية</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-4">عرض المنتجات التي كمية المخزون فيها أقل من 10</p>
            <div class="flex flex-wrap gap-3">
                <a href="#" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-eye mr-2"></i> عرض التقرير
                </a>
                <a href="#" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-download mr-2"></i> تحميل PDF
                </a>
            </div>
        </div>

        <!-- تقرير المبيعات الشهرية -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-3">
                    <i class="fas fa-chart-line text-purple-600 dark:text-purple-300 text-xl"></i>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">تقرير المبيعات الشهرية</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-300 mb-4">عرض إحصائيات المبيعات لهذا الشهر</p>
            <div class="flex flex-wrap gap-3">
                <a href="#" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-eye mr-2"></i> عرض التقرير
                </a>
                <a href="#" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-download mr-2"></i> تحميل PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection