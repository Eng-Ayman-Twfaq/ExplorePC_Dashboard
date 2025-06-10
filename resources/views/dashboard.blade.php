<x-app-layout>
    <div class="flex h-screen bg-gray-100 dark:bg-gray-900">
        <!-- المحتوى الرئيسي -->
        <div class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-800">
            <div class="p-6">
                <!-- شريط العنوان -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <img src="{{ asset('images/Explore.png') }}"
                             alt="Explore PC Logo"
                             class="h-10 mr-2 transition-transform duration-300 hover:scale-110">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">لوحة تحكم Explore PC</h1>
                    </div>
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text"
                                   class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="بحث...">
                        </div>
                        <button class="p-2 rounded-full bg-white dark:bg-gray-700 shadow hover:bg-gray-100 dark:hover:bg-gray-600">
                            <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                </div>

                <!-- بطاقات الإحصائيات -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- بطاقة التجار -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 mr-4">
                                <i class="fas fa-store text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">عدد التجار</p>
                                <h3 class="font-bold text-2xl dark:text-white">{{ $merchants_count }}</h3>
                                <p class="text-green-500 text-xs mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i> 12% عن الشهر الماضي
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- بطاقة المنتجات -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 mr-4">
                                <i class="fas fa-laptop text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">المنتجات</p>
                                <h3 class="font-bold text-2xl dark:text-white">{{ $products_count }}</h3>
                                <p class="text-green-500 text-xs mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i> 8% عن الشهر الماضي
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- بطاقة العملاء -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">العملاء</p>
                                <h3 class="font-bold text-2xl dark:text-white">{{ $customers_count }}</h3>
                                <p class="text-green-500 text-xs mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i> 5% عن الشهر الماضي
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- بطاقة المبيعات -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-400 mr-4">
                                <i class="fas fa-shopping-cart text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">الطلبات</p>
                                <h3 class="font-bold text-2xl dark:text-white">{{ $orders_count }}</h3>
                                <p class="text-green-500 text-xs mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i> 15% عن الشهر الماضي
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الرسوم البيانية -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- مخطط أداء التجار -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                                أداء التجار
                            </h3>
                            <select class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-gray-50 dark:bg-gray-600 dark:text-white">
                                <option>آخر 6 أشهر</option>
                                <option>هذا العام</option>
                            </select>
                        </div>
                        <canvas id="merchantsChart" height="250"></canvas>
                    </div>

                    <!-- مخطط توزيع المنتجات حسب التجار -->
                    <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                <i class="fas fa-store text-green-500 mr-2"></i>
                                توزيع المنتجات حسب التجار
                            </h3>
                            <select class="text-sm border border-gray-200 dark:border-gray-600 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-200 bg-gray-50 dark:bg-gray-600 dark:text-white">
                                <option>أفضل 5 تجار</option>
                                <option>جميع التجار</option>
                            </select>
                        </div>
                        <canvas id="merchantsProductsChart" height="250"></canvas>
                    </div>
                </div>

                <!-- قائمة التجار -->
              <!-- قائمة التجار - نسخة محسنة -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-store text-purple-500 mr-2"></i>
            أحدث التجار المسجلين
        </h3>
        <a href="{{ route('merchants.index') }}" class="text-sm flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
            عرض الكل <i class="fas fa-chevron-left mr-1 rtl:mr-0 rtl:ml-1 text-xs"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاجر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المتجر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المنتجات</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ التسجيل</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($latest_merchants as $merchant)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 flex items-center justify-center">
                                @if($merchant->logo)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/'.$merchant->logo) }}" alt="Logo">
                                @else
                                    <i class="fas fa-store text-blue-600 dark:text-blue-400"></i>
                                @endif
                            </div>
                            <div class="mr-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $merchant->name ?? 'غير محدد' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                    <i class="fas fa-envelope text-xs mr-1"></i> {{ $merchant->email ?? '--' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $merchant->storename ?? '--' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $merchant->$products_count ?? 0 }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-4 font-medium rounded-full {{ $merchant->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                            <i class="fas {{ $merchant->is_active ? 'fa-check-circle mr-1' : 'fa-exclamation-circle mr-1' }}"></i>
                            {{ $merchant->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center">
                            <i class="far fa-calendar-alt mr-1 text-xs"></i>
                            {{ $merchant->created_at ? $merchant->created_at->translatedFormat('d/m/Y') : '--' }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- آخر الطلبات - نسخة محسنة -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-clock text-yellow-500 mr-2"></i>
            آخر الطلبات
        </h3>
        <a href="{{ route('orders.index') }}" class="text-sm flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
            عرض الكل <i class="fas fa-chevron-left mr-1 rtl:mr-0 rtl:ml-1 text-xs"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">العميل</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاجر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المجموع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاريخ</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($latest_orders as $order)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-blue-600 dark:text-blue-400">
                            #{{ $order->order_number ?? '--' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 dark:text-gray-300 text-xs"></i>
                            </div>
                            <div class="mr-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->customer->name ?? 'عميل محذوف' }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ optional($order->customer)->phone ?? '--' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i class="fas fa-store text-blue-600 dark:text-blue-400 text-xs"></i>
                            </div>
                            <div class="text-sm text-gray-900 dark:text-white mr-3">
                                {{ $order->merchant->store_name ?? 'تاجر محذوف' }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusData = [
                                'completed' => ['color' => 'green', 'icon' => 'fa-check-circle'],
                                'processing' => ['color' => 'yellow', 'icon' => 'fa-sync-alt'],
                                'shipped' => ['color' => 'blue', 'icon' => 'fa-truck'],
                                'cancelled' => ['color' => 'red', 'icon' => 'fa-times-circle']
                            ];
                            $status = $statusData[$order->status] ?? ['color' => 'gray', 'icon' => 'fa-question-circle'];
                        @endphp
                        <span class="px-2.5 py-1 inline-flex items-center text-xs leading-4 font-medium rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800 dark:bg-{{ $status['color'] }}-900/30 dark:text-{{ $status['color'] }}-400">
                            <i class="fas {{ $status['icon'] }} mr-1"></i>
                            {{ __('orders.status.' . ($order->status ?? 'unknown')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        {{ number_format($order->total ?? 0, 2) }} <span class="text-gray-500">$</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        <div class="flex items-center">
                            <i class="far fa-clock text-xs mr-1"></i>
                            {{ $order->created_at ? $order->created_at->translatedFormat('d/m/Y') : '--' }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    <!-- السكريبتات -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // مخطط أداء التجار
            const merchantsCtx = document.getElementById('merchantsChart').getContext('2d');
            const merchantsChart = new Chart(merchantsCtx, {
                type: 'bar',
                data: {
                    labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
                    datasets: [{
                        label: 'أداء التجار',
                        data: [12, 15, 11, 18, 21, 19],
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' تاجر';
                                }
                            }
                        }
                    }
                }
            });

            // مخطط توزيع المنتجات حسب التجار
            const merchantsProductsCtx = document.getElementById('merchantsProductsChart').getContext('2d');
            const merchantsProductsChart = new Chart(merchantsProductsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['تكنو ستور', 'علي كمبيوتر', 'خالد إلكترونيات', 'الرحمة للتجارة', 'أحمد للإلكترونيات'],
                    datasets: [{
                        data: [28, 35, 18, 12, 7],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(139, 92, 246, 0.7)',
                            'rgba(239, 68, 68, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'right',
                            rtl: true,
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
