@extends('layouts.app')

@section('title', 'إدارة التجار')
@section('header', 'إدارة التجار')

@section('content')
    @if(session('success'))
    <div id="alert-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 dark:bg-green-900 dark:border-green-700 dark:text-green-200" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            {{-- <svg class="fill-current h-6 w-6 text-green-500 dark:text-green-400" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> --}}
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        {{-- <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">قائمة التجار</h2> --}}

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <a href="{{ route('merchants.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600 flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> إضافة تاجر جديد
            </a>

            <a href="{{ route('documents.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 dark:bg-blue-700 dark:hover:bg-blue-600 flex items-center justify-center">
                <i class="fas fa-file-alt mr-2"></i> الوثائق
            </a>
        </div>
    </div>

    <!-- فلترة التجار -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <form action="{{ route('merchants.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- فلترة حسب اسم التاجر -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم التاجر</label>
                <input type="text" name="name" id="name" value="{{ request('name') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200"
                       placeholder="ابحث باسم التاجر">
            </div>

            <!-- فلترة حسب اسم المتجر -->
            <div>
                <label for="storename" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم المتجر</label>
                <input type="text" name="storename" id="storename" value="{{ request('storename') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200"
                       placeholder="ابحث باسم المتجر">
            </div>

            <!-- فلترة حسب التقييم -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التقييم الأدنى</label>
                <input type="number" name="rating" id="rating" min="0" max="5" step="0.1"
                       value="{{ request('rating') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200"
                       placeholder="من 0 إلى 5">
            </div>

            <!-- أزرار الفلترة -->
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600 h-[42px]">
                    <i class="fas fa-search mr-1"></i> بحث
                </button>
                <a href="{{ route('merchants.index') }}"
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 h-[42px] flex items-center">
                    <i class="fas fa-redo mr-1"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">قائمة التجار</h2>
    <!-- جدول التجار -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الاسم</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المتجر</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الهاتف</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التقييم</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($merchants as $merchant)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $merchant->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $merchant->storename }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $merchant->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $merchant->phoneNumber }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($merchant->rating))
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @elseif($i == ceil($merchant->rating) && $merchant->rating > floor($merchant->rating))
                                        <svg class="w-4 h-4 text-yellow-400" fill="half" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="mr-2 text-gray-600 dark:text-gray-300 text-sm">{{ number_format($merchant->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <a href="{{ route('merchants.edit', $merchant->MerchantId) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200"
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('merchants.destroy', $merchant->MerchantId) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200"
                                            title="حذف"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا التاجر؟')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('documents.create', ['merchant_id' => $merchant->MerchantId]) }}"
                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200"
                                   title="إضافة وثيقة">
                                    <i class="fas fa-file-upload"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            @if(request()->anyFilled(['name', 'storename', 'rating']))
                                لا توجد نتائج مطابقة لمعايير البحث
                            @else
                                لا توجد تجار مسجلين بعد
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- الترقيم -->
        {{-- @if($merchants->hasPages())
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $merchants->appends(request()->query())->links() }}
        </div>
        @endif --}}
    </div>

    @push('scripts')
    <script>
        // إخفاء رسالة النجاح بعد 5 ثواني
        setTimeout(() => {
            const alert = document.getElementById('alert-message');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 5000);

        // إغلاق الرسالة عند النقر على زر الإغلاق
        document.querySelectorAll('[title="Close"]').forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('[role="alert"]');
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        });
    </script>
    @endpush
@endsection
