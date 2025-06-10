@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">تقرير المبيعات اليومية - {{ $data['date'] }}</h1>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form method="GET" action="{{ route('reports.daily') }}" class="flex items-center gap-2">
                <select name="date" onchange="this.form.submit()" 
                        class="border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    @foreach($data['dates'] as $d)
                        <option value="{{ $d }}" {{ $d == $data['date'] ? 'selected' : '' }}>
                            {{ $d }}
                        </option>
                    @endforeach
                </select>
            </form>
            
            <div class="flex gap-2">
                <a href="{{ route('reports.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> رجوع
                </a>
                <a href="{{ route('reports.download', ['date' => $data['date']]) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-download mr-2"></i> تحميل PDF
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <p class="text-gray-600 dark:text-gray-300">عدد الطلبات</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $data['total_orders'] }}</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <p class="text-gray-600 dark:text-gray-300">إجمالي الإيراد</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ number_format($data['total_revenue'], 2) }} $</p>
            </div>
            <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                <p class="text-gray-600 dark:text-gray-300">متوسط قيمة الطلب</p>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-300">
                    {{ $data['total_orders'] > 0 ? number_format($data['total_revenue'] / $data['total_orders'], 2) : 0 }} $
                </p>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">طرق الدفع</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-right text-sm font-medium text-gray-500 dark:text-gray-300 uppercase">طريقة الدفع</th>
                            <th class="py-3 px-4 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase">عدد الطلبات</th>
                            <th class="py-3 px-4 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase">المبلغ</th>
                            <th class="py-3 px-4 text-center text-sm font-medium text-gray-500 dark:text-gray-300 uppercase">النسبة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                        @foreach($data['payment_methods'] as $method => $payments)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-3 px-4 text-right text-gray-800 dark:text-gray-200">
                                @if($method == 'wallet') 
                                    <i class="fas fa-wallet mr-2 text-blue-500"></i> محفظة جوالي
                                @elseif($method == 'bank_transfer') 
                                    <i class="fas fa-university mr-2 text-green-500"></i> تحويل بنكي
                                @elseif($method == 'cash') 
                                    <i class="fas fa-money-bill-wave mr-2 text-gray-500"></i> نقداً
                                @else 
                                    <i class="fas fa-credit-card mr-2 text-purple-500"></i> {{ $method }}
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">{{ $payments->count() }}</td>
                            <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">{{ number_format($payments->sum('amount'), 2) }} $</td>
                            <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">
                                {{ $data['total_revenue'] > 0 ? round(($payments->sum('amount') / $data['total_revenue']) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(!empty($data['top_products']))
        <div>
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">أفضل المنتجات مبيعاً</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($data['top_products'] as $productData)
                <div class="bg-gray-50 dark:bg-gray-600 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        @if($productData['product']->image)
                        <img src="{{ asset('storage/' . $productData['product']->image) }}" 
                             class="w-12 h-12 object-cover rounded-md mr-2" 
                             alt="{{ $productData['product']->name }}">
                        @else
                        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-500 rounded-md flex items-center justify-center mr-2">
                            <i class="fas fa-box text-gray-400"></i>
                        </div>
                        @endif
                        <div>
                            <h3 class="font-medium text-gray-800 dark:text-white">{{ $productData['product']->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $productData['quantity'] }} وحدة</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection