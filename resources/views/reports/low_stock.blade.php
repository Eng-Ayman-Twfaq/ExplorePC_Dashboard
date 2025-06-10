@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">تقرير المنتجات شبه المنتهية</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 text-right">اسم المنتج</th>
                    <th class="py-2 px-4 text-right">الكمية المتبقية</th>
                    <th class="py-2 px-4 text-right">التصنيف</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-t {{ $product->stockQuantity < 5 ? 'bg-red-50' : '' }}">
                    <td class="py-2 px-4">{{ $product->name }}</td>
                    <td class="py-2 px-4 text-center {{ $product->stockQuantity < 5 ? 'text-red-600 font-bold' : '' }}">
                        {{ $product->stockQuantity }}
                        @if($product->stockQuantity < 5)
                        <span class="text-xs text-red-500">(كمية حرجة)</span>
                        @endif
                    </td>
                    <td class="py-2 px-4">{{ $product->category }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('reports.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">
            رجوع
        </a>
        <a href="{{ route('reports.download-low-stock') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg mr-2">
            <i class="fas fa-download mr-2"></i> تحميل PDF
        </a>
    </div>
</div>
@endsection
