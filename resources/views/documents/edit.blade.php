@extends('layouts.app')

@section('title', 'تعديل وثيقة')
@section('header', 'تعديل وثيقة')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <form action="{{ route('documents.update', $document->documentId) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- حقل التاجر (غير قابل للتعديل) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">التاجر</label>
                    <p class="mt-1 p-2 bg-gray-100 dark:bg-gray-700 rounded-md dark:text-gray-200">
                        {{ $document->merchant->name }} ({{ $document->merchant->storename }})
                    </p>
                </div>

                <!-- حقل نوع الوثيقة -->
                <div>
                    <label for="documentType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">نوع الوثيقة *</label>
                    <select name="documentType" id="documentType" required
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="commercial_register" {{ $document->documentType == 'commercial_register' ? 'selected' : '' }}>سجل تجاري</option>
                        <option value="tax_card" {{ $document->documentType == 'tax_card' ? 'selected' : '' }}>بطاقة ضريبية</option>
                        <option value="id_copy" {{ $document->documentType == 'id_copy' ? 'selected' : '' }}>صورة بطاقة</option>
                    </select>
                    @error('documentType')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل صورة الوثيقة -->
                <div>
                    <label for="documentImage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">صورة الوثيقة الجديدة</label>
                    <input type="file" name="documentImage" id="documentImage" accept="image/*,.pdf"
                           class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                    @error('documentImage')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        الملف الحالي:
                        <a href="{{ Storage::url($document->documentImage) }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                            معاينة الوثيقة
                        </a>
                    </p>
                </div>

                <!-- حقل حالة الوثيقة -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الحالة *</label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">
                        <option value="pending" {{ $document->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                        <option value="approved" {{ $document->status == 'approved' ? 'selected' : '' }}>مقبولة</option>
                        <option value="rejected" {{ $document->status == 'rejected' ? 'selected' : '' }}>مرفوضة</option>
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
                    حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
