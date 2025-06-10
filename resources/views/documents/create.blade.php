@extends('layouts.app')

@section('title', 'إضافة وثيقة جديدة')
@section('header', 'إضافة وثيقة جديدة')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- حقل التاجر -->
                <div>
                    <label for="MerchantId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">التاجر *</label>
                    <select name="MerchantId" id="MerchantId" required
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">اختر تاجر...</option>
                        @foreach($merchants as $merchant)
                            <option value="{{ $merchant->MerchantId }}" {{ old('MerchantId') == $merchant->MerchantId ? 'selected' : '' }}>
                                {{ $merchant->name }} ({{ $merchant->storename }})
                            </option>
                        @endforeach
                    </select>
                    @error('MerchantId')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل نوع الوثيقة -->
                <div>
                    <label for="documentType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">نوع الوثيقة *</label>
                    <select name="documentType" id="documentType" required
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">اختر النوع...</option>
                        <option value="commercial_register" {{ old('documentType') == 'commercial_register' ? 'selected' : '' }}>سجل تجاري</option>
                        <option value="tax_card" {{ old('documentType') == 'tax_card' ? 'selected' : '' }}>بطاقة ضريبية</option>
                        <option value="id_copy" {{ old('documentType') == 'id_copy' ? 'selected' : '' }}>صورة بطاقة</option>
                    </select>
                    @error('documentType')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل صورة الوثيقة -->
                <div>
                    <label for="documentImage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">صورة الوثيقة *</label>
                    <input type="file" name="documentImage" id="documentImage" required accept="image/*,.pdf"
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('documentImage')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">يسمح بملفات الصور (JPG, PNG) أو PDF بحجم أقصى 2MB</p>
                </div>

                <!-- حقل حالة الوثيقة -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الحالة *</label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>مقبولة</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('documents.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                    إلغاء
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md shadow-sm hover:bg-indigo-700 transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                    حفظ الوثيقة
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
