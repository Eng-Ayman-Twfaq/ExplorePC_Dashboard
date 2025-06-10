@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout>
    <div class="py-12 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة منتج جديد</h2>
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

                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- اسم المنتج -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم المنتج *</label>
                                <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                       placeholder="أدخل اسم المنتج">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- التاجر -->
                            <div>
                                <label for="MerchantId" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التاجر *</label>
                                <select name="MerchantId" id="MerchantId" required
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600">
                                    <option value="">اختر التاجر</option>
                                    @foreach($merchants as $merchant)
                                        <option value="{{ $merchant->MerchantId }}" {{ old('MerchantId') == $merchant->MerchantId ? 'selected' : '' }}>
                                            {{ $merchant->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('MerchantId')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- الوصف -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الوصف</label>
                                <textarea id="description" name="description" rows="3"
                                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                          placeholder="أدخل وصف المنتج">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- السعر -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السعر *</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="0.01" id="price" name="price" required value="{{ old('price') }}"
                                           class="w-full pl-4 pr-12 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                           placeholder="0.00">
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- الكمية -->
                            <div>
                                <label for="stockQuantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الكمية المتاحة *</label>
                                <input type="number" id="stockQuantity" name="stockQuantity" required value="{{ old('stockQuantity') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                       placeholder="أدخل الكمية">
                                @error('stockQuantity')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- التقييم -->
                            <div>
                                <label for="ratings" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">التقييم (من 5)</label>
                                <div class="flex items-center">
                                    <input type="number" step="0.1" min="0" max="5" id="ratings" name="ratings" value="{{ old('ratings', 0) }}"
                                           class="w-20 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600">
                                    <div class="flex ml-3 rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 text-gray-300 dark:text-gray-500 rating-star" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
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
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الفئة</label>
                                <input type="text" id="category" name="category" value="{{ old('category') }}"
                                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                       placeholder="أدخل الفئة">
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- صورة المنتج -->
                            <div class="md:col-span-2">
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">صورة المنتج</label>
                                <div class="mt-1 flex items-center">
                                    <div class="relative w-full">
                                        <label for="image" class="cursor-pointer">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">اضغط لرفع صورة</span> أو اسحبها هنا
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF (حتى 2MB)</p>
                                                </div>
                                            </div>
                                            <input id="image" name="image" type="file" class="hidden" onchange="previewImage(this)">
                                        </label>
                                    </div>
                                </div>
                                <div id="image-preview" class="mt-2 hidden">
                                    <img id="preview" class="h-32 rounded-lg border border-gray-300 dark:border-gray-600" src="#" alt="Preview" />
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors">
                                إلغاء
                            </a>
                            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition-colors">
                                <i class="fas fa-save mr-2"></i> حفظ المنتج
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        // تهيئة النجوم الأولية
        document.addEventListener('DOMContentLoaded', function() {
            const initialRating = document.getElementById('ratings').value;
            if (initialRating) {
                updateStars(initialRating);
            }
        });
    </script>
    @endpush
</x-app-layout>
