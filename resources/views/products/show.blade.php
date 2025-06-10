@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-dark-800 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <!-- زر الرجوع -->
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mb-4">
            <i class="fas fa-arrow-right ml-2"></i>
            رجوع إلى قائمة المنتجات
        </a>

        <!-- بطاقة تفاصيل المنتج -->
        <div class="bg-white dark:bg-dark-700 rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- صورة المنتج -->
                <div class="md:w-1/3 p-6 flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto max-h-96 object-contain rounded-lg hover:scale-105 transition-transform">
                    @else
                        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center rounded-lg">
                            <i class="fas fa-box text-6xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                    @endif
                </div>

                <!-- تفاصيل المنتج -->
                <div class="md:w-2/3 p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $product->name }}</h1>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $product->category }}</div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('products.edit', $product->productId) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 p-2" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->productId) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-2" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($product->price, 2) }} $</span>
                        @if($product->discount)
                            <span class="text-sm text-red-600 dark:text-red-400 line-through ml-2">{{ number_format($product->price + $product->discount, 2) }} $</span>
                        @endif
                    </div>

                    <div class="flex items-center mb-4">
                        <div class="flex rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->ratings))
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @elseif($i == ceil($product->ratings) && $product->ratings > floor($product->ratings))
                                    <svg class="w-5 h-5 text-yellow-400" fill="half" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                            <span class="mr-2 text-gray-600 dark:text-gray-300">{{ number_format($product->rating, 1) }} ({{ $product->reviews_count ?? $product->reviews->count() }} تقييمات)</span>
                        </div>
                    </div>

                    <div class="mb-6">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            {{ $product->stockQuantity > 0 ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                            {{ $product->stockQuantity > 0 ? 'متوفر في المخزون' : 'غير متوفر' }}
                        </span>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">الوصف</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $product->description ?? 'لا يوجد وصف متاح' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">التاجر</h4>
                            <p class="text-gray-800 dark:text-gray-200">{{ $product->merchant->name ?? 'غير معروف' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإضافة</h4>
                            <p class="text-gray-800 dark:text-gray-200">{{ $product->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">الكمية المتاحة</h4>
                            <p class="text-gray-800 dark:text-gray-200">{{ $product->stockQuantity }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">الرمز</h4>
                            <p class="text-gray-800 dark:text-gray-200">{{ $product->productId }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center transition-all">
                            <i class="fas fa-shopping-cart mr-2"></i> إضافة إلى السلة
                        </button>
                        <button class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg flex items-center transition-all">
                            <i class="far fa-heart mr-2"></i> المفضلة
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- قسم التقييمات -->
        <div class="mt-8 bg-white dark:bg-dark-700 rounded-lg shadow-lg overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">التقييمات</h2>

            @if($product->reviews && $product->reviews->count() > 0)
                @foreach($product->reviews as $review)
                <div class="border-b border-gray-200 dark:border-gray-600 py-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-medium text-gray-800 dark:text-gray-200">{{ $review->user->name ?? 'مستخدم مجهول' }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="flex mb-2 rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <p class="text-gray-600 dark:text-gray-400">{{ $review->comment }}</p>
                </div>
                @endforeach
            @else
                <p class="text-gray-600 dark:text-gray-400">لا توجد تقييمات حتى الآن.</p>
            @endif
        </div>
    </div>
</div>
@endsection
