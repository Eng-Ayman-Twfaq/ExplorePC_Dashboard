@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تعديل المنتج: {{ $product->name }}</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center">
            <i class="fas fa-arrow-left ml-2"></i> رجوع
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 rounded">
            <div class="font-bold">خطأ!</div>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->productId) }}" method="POST" enctype="multipart/form-data"
          class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 transition-all duration-300">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- التاجر (غير قابل للتعديل) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التاجر</label>
                <div class="mt-1 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg dark:text-gray-200">
                    <div class="font-medium">{{ $product->merchant->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $product->merchant->storename }}</div>
                </div>
            </div>

            <!-- الاسم -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم المنتج *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- السعر مع رمز العملة -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر *</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <span class="text-gray-500 dark:text-gray-400">$</span>
                    </div>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}"
                           class="block w-full pl-12 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" required>
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الكمية -->
            <div>
                <label for="stockQuantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية المتاحة *</label>
                <input type="number" name="stockQuantity" id="stockQuantity" value="{{ old('stockQuantity', $product->stockQuantity) }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" required>
                @error('stockQuantity')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- التقييم -->
            <div>
                <label for="ratings" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التقييم (من 5)</label>
                <div class="flex items-center">
                    <input type="number" step="0.1" min="0" max="5" name="ratings" id="ratings" value="{{ old('ratings', $product->ratings) }}"
                           class="w-20 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    <div class="flex ml-3 rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= floor(old('ratings', $product->ratings)) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-500' }} rating-star"
                                 data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                @error('ratings')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الفئة -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الفئة *</label>
                <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100" required>
                @error('category')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الصورة -->
            <div class="md:col-span-2">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">صورة المنتج</label>
                @if($product->image)
                    <div class="mb-3 flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                             class="h-24 w-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        <label class="cursor-pointer">
                            <input type="checkbox" name="remove_image" value="1" class="mr-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">حذف الصورة الحالية</span>
                        </label>
                    </div>
                @endif
                <div class="flex items-center justify-center w-full">
                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">اضغط لرفع صورة</span> أو اسحبها هنا
                            </p>
                        </div>
                        <input id="image" name="image" type="file" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <div id="image-preview" class="mt-2 hidden">
                    <img id="preview" class="h-32 rounded-lg border border-gray-300 dark:border-gray-600" src="#" alt="Preview" />
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الوصف -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                إلغاء
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-save mr-2"></i> حفظ التغييرات
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // معاينة الصورة قبل الرفع
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // تفاعل نجوم التقييم
    document.querySelectorAll('.rating-star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            document.getElementById('ratings').value = rating;
            updateStars(rating);
        });
    });

    function updateStars(rating) {
        document.querySelectorAll('.rating-star').forEach(star => {
            const starRating = star.getAttribute('data-rating');
            if (starRating <= rating) {
                star.classList.remove('text-gray-300', 'dark:text-gray-500');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300', 'dark:text-gray-500');
            }
        });
    }

    // تحديث النجوم عند تغيير القيمة يدوياً
    document.getElementById('ratings').addEventListener('input', function() {
        updateStars(this.value);
    });
</script>
@endpush
@endsection
