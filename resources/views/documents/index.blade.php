@extends('layouts.app')

@section('title', 'إدارة الوثائق')
@section('header', 'إدارة الوثائق')

@section('content')
    @if(session('success'))
    <div id="alert-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 dark:bg-green-900 dark:border-green-700 dark:text-green-200" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            {{-- <svg class="fill-current h-6 w-6 text-green-500 dark:text-green-400 " role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"> --}}
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        {{-- <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">قائمة الوثائق</h2> --}}

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <a href="{{ route('documents.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600 flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i> إضافة وثيقة جديدة
            </a>

            <a href="{{ route('merchants.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 dark:bg-blue-700 dark:hover:bg-blue-600 flex items-center justify-center">
                <i class="fas fa-users mr-2"></i> التجار
            </a>
        </div>
    </div>

    <!-- فلترة الوثائق -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mb-6">
        <form action="{{ route('documents.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- فلترة حسب التاجر -->
            <div>
                <label for="merchant_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التاجر</label>
                <select name="merchant_id" id="merchant_id"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    <option value="">جميع التجار</option>
                    @foreach($merchants as $merchant)
                        <option value="{{ $merchant->MerchantId }}"
                                {{ request('merchant_id') == $merchant->MerchantId ? 'selected' : '' }}>
                            {{ $merchant->name }} ({{ $merchant->storename }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- فلترة حسب نوع الوثيقة -->
            <div>
                <label for="documentType" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نوع الوثيقة</label>
                <select name="documentType" id="documentType"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    <option value="">جميع الأنواع</option>
                    <option value="commercial_register" {{ request('documentType') == 'commercial_register' ? 'selected' : '' }}>سجل تجاري</option>
                    <option value="tax_card" {{ request('documentType') == 'tax_card' ? 'selected' : '' }}>بطاقة ضريبية</option>
                    <option value="id_copy" {{ request('documentType') == 'id_copy' ? 'selected' : '' }}>صورة بطاقة</option>
                </select>
            </div>

            <!-- فلترة حسب الحالة -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبولة</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                </select>
            </div>

            <!-- أزرار الفلترة -->
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600 h-[42px]">
                    <i class="fas fa-search mr-1"></i> بحث
                </button>
                <a href="{{ route('documents.index') }}"
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 h-[42px] flex items-center">
                    <i class="fas fa-redo mr-1"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">قائمة الوثائق</h2>
    <!-- جدول الوثائق -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاجر</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نوع الوثيقة</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ الرفع</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الوثيقة</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($documents as $document)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ $document->merchant->name }} ({{ $document->merchant->storename }})
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            @switch($document->documentType)
                                @case('commercial_register') سجل تجاري @break
                                @case('tax_card') بطاقة ضريبية @break
                                @case('id_copy') صورة بطاقة @break
                                @default {{ $document->documentType }}
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $document->uploadDate }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @switch($document->status)
                                    @case('approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @break
                                    @case('rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @break
                                    @default bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @endswitch">
                                @switch($document->status)
                                    @case('approved') مقبولة @break
                                    @case('rejected') مرفوضة @break
                                    @default قيد المراجعة
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ Storage::url($document->documentImage) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                <i class="fas fa-eye mr-1"></i> معاينة
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <a href="{{ route('documents.edit', $document->documentId) }}"
                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200"
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document->documentId) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200"
                                            title="حذف"
                                            onclick="return confirm('هل أنت متأكد من حذف هذه الوثيقة؟')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            @if(request()->anyFilled(['merchant_id', 'documentType', 'status']))
                                لا توجد نتائج مطابقة لمعايير البحث
                            @else
                                لا توجد وثائق مسجلة بعد
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- الترقيم -->
        @if($documents->hasPages())
        <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $documents->appends(request()->query())->links() }}
        </div>
        @endif
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
