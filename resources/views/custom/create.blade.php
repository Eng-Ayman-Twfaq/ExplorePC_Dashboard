@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">إضافة عميل جديد</h1>
        <a href="{{ route('custom.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center">
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

    <form action="{{ route('custom.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 transition-all duration-300">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- الاسم -->
            <div>
                <label for="UserName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم العميل *</label>
                <input type="text" name="UserName" id="UserName" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                       placeholder="أدخل اسم العميل">
                @error('UserName')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- البريد الإلكتروني -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البريد الإلكتروني *</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                       placeholder="أدخل البريد الإلكتروني">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- كلمة المرور -->
            <div>
                <label for="UserPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">كلمة المرور *</label>
                <div class="relative">
                    <input type="password" name="UserPassword" id="UserPassword" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 pr-10"
                           placeholder="أدخل كلمة المرور">
                    <button type="button" onclick="togglePassword('UserPassword')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('UserPassword')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الهاتف -->
            <div>
                <label for="Phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">رقم الهاتف *</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">
                        +967
                    </span>
                    <input type="tel" name="Phone" id="Phone" required
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-r-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                           placeholder="5XXXXXXXX">
                </div>
                @error('Phone')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- العنوان -->
            <div class="md:col-span-2">
                <label for="Address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">العنوان *</label>
                <textarea name="Address" id="Address" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100"
                          placeholder="أدخل العنوان الكامل"></textarea>
                @error('Address')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- الصورة -->
            <div class="md:col-span-2">
                <label for="Image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">صورة العميل</label>
                <div class="flex items-center justify-center w-full">
                    <label for="Image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">اضغط لرفع صورة</span> أو اسحبها هنا
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG (حتى 2MB)</p>
                        </div>
                        <input id="Image" name="Image" type="file" class="hidden" onchange="previewImage(this)">
                    </label>
                </div>
                <div id="image-preview" class="mt-2 hidden">
                    <img id="preview" class="h-32 rounded-lg border border-gray-300 dark:border-gray-600" src="#" alt="Preview" />
                </div>
                @error('Image')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
            <button type="reset" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-undo mr-2"></i> إعادة تعيين
            </button>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i class="fas fa-save mr-2"></i> حفظ العميل
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

    // إظهار/إخفاء كلمة المرور
    function togglePassword(id) {
        const passwordField = document.getElementById(id);
        const icon = passwordField.nextElementSibling.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endpush
@endsection
