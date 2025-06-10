<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('إرسال إشعار جديد') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('admin.notifications.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('عنوان الإشعار') }}</label>
                            <input type="text" id="title" name="title" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('محتوى الإشعار') }}</label>
                            <textarea id="message" name="message" rows="4" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('المستخدم') }}</label>
                            <select id="user_id" name="user_id" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">اختر مستخدم</option>
                                @foreach($users as $user)
                                <option value="{{ $user->UserId }}">{{ $user->UserName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                {{ __('إرسال الإشعار') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>