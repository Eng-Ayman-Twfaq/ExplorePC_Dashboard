@extends('layouts.app')

@section('title', 'إضافة تاجر جديد')
@section('header', 'إضافة تاجر جديد')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <form action="{{ route('merchants.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- حقل الاسم -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم التاجر *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل اسم المتجر -->
                <div>
                    <label for="storename" class="block text-sm font-medium text-gray-700 dark:text-gray-300">اسم المتجر *</label>
                    <input type="text" name="storename" id="storename" value="{{ old('storename') }}" required
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('storename')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل البريد الإلكتروني -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل الهاتف -->
            <div>
    <label for="phoneNumber" class="block text-sm font-medium text-gray-700 dark:text-gray-300">رقم الهاتف *</label>
    <input type="text" 
           name="phoneNumber" 
           id="phoneNumber" 
           value="{{ old('phoneNumber') }}" 
           required
           pattern="^(77|78|71|70|73)[0-9]{7}$"
           title="يجب أن يتكون رقم الهاتف من 9 أرقام ويبدأ بـ 77، 78، 71، 70 أو 73"
           oninput="this.value = this.value.replace(/[^0-9]/g, ''); validatePhoneNumber(this)"
           maxlength="9"
           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
    
    @error('phoneNumber')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
    
    <p id="phoneError" class="mt-1 text-sm text-red-600 dark:text-red-400 hidden">
        يجب أن يتكون رقم الهاتف من 9 أرقام ويبدأ بـ 77، 78، 71، 70 أو 73
    </p>
</div>

<script>
function validatePhoneNumber(input) {
    const phoneError = document.getElementById('phoneError');
    const phonePattern = /^(77|78|71|70|73)[0-9]{7}$/;
    
    if (input.value.length > 0 && !phonePattern.test(input.value)) {
        phoneError.classList.remove('hidden');
        input.setCustomValidity('رقم الهاتف غير صحيح');
    } else {
        phoneError.classList.add('hidden');
        input.setCustomValidity('');
    }
    
    // التحكم في الطول الأقصى
    if (input.value.length > 9) {
        input.value = input.value.slice(0, 9);
    }
}
</script>

                <!-- حقل العنوان -->
                <div class="md:col-span-2">
                    <label for="Address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">العنوان</label>
                    <textarea name="Address" id="Address" rows="2"
                              class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">{{ old('Address') }}</textarea>
                    @error('Address')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل التقييم -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">التقييم (0-5)</label>
                    <input type="number" name="rating" id="rating" min="0" max="5" step="0.1" value="{{ old('rating', 0) }}"
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('merchants.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                    إلغاء
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                    حفظ التاجر
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
