{{-- @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">إدارة المنتجات</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> إضافة منتج جديد
        </a>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">فلترة المنتجات</h2>
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- حقل البحث -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">بحث</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- فلترة حسب الفئة -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">الفئة</label>
                <select name="category" id="category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الفئات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <!-- فلترة حسب السعر -->
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700">السعر من</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700">السعر إلى</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

           <!-- فلترة حسب التاجر -->
<div>
    <label for="MerchantId" class="block text-sm font-medium text-gray-700">التاجر</label>
    <select name="MerchantId" id="MerchantId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <option value="">جميع التجار</option>
        @foreach($merchants as $merchant)
            <option value="{{ $merchant->MerchantId }}" {{ request('MerchantId') == $merchant->MerchantId ? 'selected' : '' }}>
                {{ $merchant->name }}
            </option>
        @endforeach
    </select>
</div>

            <!-- فلترة حسب التقييم -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">التقييم</label>
                <select name="rating" id="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">الكل</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم فأكثر</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم فأكثر</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم فأكثر</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة فأكثر</option>
                </select>
            </div>

            <!-- ترتيب النتائج -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700">ترتيب حسب</label>
                <select name="sort" id="sort" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">الافتراضي</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر (منخفض إلى مرتفع)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر (مرتفع إلى منخفض)</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>أعلى التقييمات</option>
                </select>
            </div>

            <!-- أزرار الفلترة -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-filter mr-2"></i> تطبيق الفلتر
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-times mr-2"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الصورة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاجر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">السعر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الكمية</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التقييم</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover">
                        @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-box text-gray-400"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        <div class="text-sm text-gray-500">{{ $product->category }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $product->merchant->name ?? 'غير معروف' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ number_format($product->price, 2) }} $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $product->stockQuantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stockQuantity }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->ratings))
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @elseif($i == ceil($product->ratings) && $product->ratings > floor($product->ratings))
                                    <svg class="w-4 h-4 text-yellow-400" fill="half" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="mr-2 text-gray-600 dark:text-gray-300 text-sm">{{ number_format($product->rating, 1) }}</span>
                        </div>
                    </td>
                    {{-- <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $product->ratings ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </td> --}}
                    {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('products.show', $product->productId) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('products.edit', $product->productId) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('products.destroy', $product->productId) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    {{-- <div class="mt-4">
        {{ $products->links() }}
    </div> --}}
{{-- </div>
@endsection --}}


@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-dark-800 min-h-screen">
    <!-- زر تبديل الوضع الداكن -->
    {{-- <button id="theme-toggle" class="theme-toggle bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full p-3 shadow-lg">
        <i id="theme-icon" class="fas fa-moon"></i>
    </button> --}}

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إدارة المنتجات</h1>
        <div class="flex space-x-2">
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition-all">
                <i class="fas fa-plus mr-2"></i> إضافة منتج جديد
            </a>
        </div>
    </div>

    <!-- فلترة المنتجات -->
    <div class="bg-white dark:bg-dark-700 shadow-md rounded-lg p-6 mb-6 transition-all card">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">فلترة المنتجات</h2>
        <!-- ... (نفس كود الفلتر السابق) ... -->
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- حقل البحث -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">بحث</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- فلترة حسب الفئة -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">الفئة</label>
                <select name="category" id="category" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">جميع الفئات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <!-- فلترة حسب السعر -->
            <div>
                <label for="min_price" class="block text-sm font-medium text-gray-700">السعر من</label>
                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="max_price" class="block text-sm font-medium text-gray-700">السعر إلى</label>
                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

           <!-- فلترة حسب التاجر -->
<div>
    <label for="MerchantId" class="block text-sm font-medium text-gray-700">التاجر</label>
    <select name="MerchantId" id="MerchantId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
        <option value="">جميع التجار</option>
        @foreach($merchants as $merchant)
            <option value="{{ $merchant->MerchantId }}" {{ request('MerchantId') == $merchant->MerchantId ? 'selected' : '' }}>
                {{ $merchant->name }}
            </option>
        @endforeach
    </select>
</div>

            <!-- فلترة حسب التقييم -->
            <div>
                <label for="rating" class="block text-sm font-medium text-gray-700">التقييم</label>
                <select name="rating" id="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">الكل</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم فأكثر</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم فأكثر</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم فأكثر</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة فأكثر</option>
                </select>
            </div>

            <!-- ترتيب النتائج -->
            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700">ترتيب حسب</label>
                <select name="sort" id="sort" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">الافتراضي</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>السعر (منخفض إلى مرتفع)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر (مرتفع إلى منخفض)</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>أعلى التقييمات</option>
                </select>
            </div>

            <!-- أزرار الفلترة -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-filter mr-2"></i> تطبيق الفلتر
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-times mr-2"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-dark-700 shadow-md rounded-lg overflow-hidden transition-all card">
        <div class="table-container">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 product-table">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الصورة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاجر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">السعر</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الكمية</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التقييم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-dark-700 divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-full object-cover hover:scale-105 transition-transform">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                    <i class="fas fa-box text-gray-400 dark:text-gray-300"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->category }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ $product->merchant->name ?? 'غير معروف' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ number_format($product->price, 2) }} $
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $product->stockQuantity > 0 ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                {{ $product->stockQuantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->ratings))
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @elseif($i == ceil($product->ratings) && $product->ratings > floor($product->ratings))
                                        <svg class="w-4 h-4 text-yellow-400" fill="half" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="mr-2 text-gray-600 dark:text-gray-300 text-sm">{{ number_format($product->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('products.show', $product->productId) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3" title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('products.edit', $product->productId) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 mr-3" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->productId) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($products->hasPages())
    <div class="mt-4 bg-white dark:bg-dark-700 p-4 rounded-lg shadow">
        {{ $products->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    // تبديل الوضع الداكن
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        themeIcon.classList.replace('fa-moon', 'fa-sun');
    } else {
        document.documentElement.classList.remove('dark');
        themeIcon.classList.replace('fa-sun', 'fa-moon');
    }

    themeToggle.addEventListener('click', function() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }
    });
</script>
@endpush
@endsection
