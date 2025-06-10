@extends('layouts.app')

@section('title', 'طلبات إعادة تعيين كلمة السر')
@section('header', 'طلبات إعادة تعيين كلمة السر')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="text-center py-4">
            <p class="text-gray-500 dark:text-gray-400">لا توجد طلبات حالياً</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الهاتف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ الإنشاء</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($requests as $request)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($request->status == 'pending')
                                    bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else
                                    bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @endif">
                                {{ $request->status == 'pending' ? 'قيد الانتظار' : 'مكتمل' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $request->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($request->status == 'pending')
                            <form action="{{ route('password-reset-requests.update', $request->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" 
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                    تمت المعالجة
                                </button>
                            </form>
                            @else
                            <span class="text-green-600 dark:text-green-400 text-sm">تمت المعالجة</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection