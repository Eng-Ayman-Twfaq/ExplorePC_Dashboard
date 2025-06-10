<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
        <!-- القائمة الجانبية -->
        <div class="w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white p-4 shadow-xl flex flex-col dark:from-gray-800 dark:to-gray-900">
            <div class="flex items-center justify-center mb-8 mt-4">
                {{-- <i class="fas fa-desktop text-3xl mr-2 text-blue-300 dark:text-blue-400"></i> --}}
                <img src="{{ asset('images/Explore.png') }}"
                     alt="Explore PC Logo"
                     class="h-10 mr-2 transition-transform duration-300 hover:scale-110">
                <span class="text-xl font-bold text-blue-100 dark:text-white">Explore PC</span>
            </div>

            <nav class="space-y-1 flex-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    <span>لوحة التحكم</span>
                </x-nav-link>

                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                    <i class="fas fa-laptop mr-3 w-5 text-center"></i>
                    <span>المنتجات</span>
                </x-nav-link>

                <x-nav-link :href="route('merchants.index')" :active="request()->routeIs('merchants.*')">
                    <i class="fas fa-store mr-3 w-5 text-center"></i>
                    <span>التجار</span>
                </x-nav-link>

                <x-nav-link href="{{ route('custom.index') }}" :active="request()->routeIs('custom.*')">
                    <i class="fas fa-users mr-3 w-5 text-center"></i>
                    <span>المستخدمين</span>
                </x-nav-link>

                <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')"
                     class="hover:bg-blue-700 rounded-lg flex items-center py-3 px-4">
                    <i class="fas fa-shopping-cart mr-3 w-5 text-center"></i>
                    <span>الطلبات</span>
                </x-nav-link>

                <x-nav-link href="{{ route('carts.index') }}" :active="request()->routeIs('carts.*')"
                    class="hover:bg-blue-700 rounded-lg flex items-center py-3 px-4">
                    <i class="fas fa-shopping-cart mr-3 w-5 text-center"></i>
                    <span>سلة التسوق</span>
                    @auth

                    @endauth
                </x-nav-link>

                <x-nav-link href="{{ route('payments.index') }}" :active="request()->routeIs('payments.*')"
                    class="hover:bg-blue-700 rounded-lg flex items-center py-3 px-4">
                    <i class="fas fa-receipt mr-3 w-5 text-center"></i>
                    <span> الطلبات المدفوعة</span>
                    @auth

                    @endauth
                </x-nav-link>
                
                <x-nav-link href="{{ route('admin.notifications.index') }}" :active="request()->routeIs('admin.notifications.*')"
    class="hover:bg-blue-700 rounded-lg flex items-center py-3 px-4">
    <i class="fas fa-bell mr-3 w-5 text-center"></i>
    <span>إدارة الإشعارات</span>
</x-nav-link>

                <x-nav-link href="{{ route('password-reset-requests.index') }}" 
           :active="request()->routeIs('password-reset-requests.*')">
    <i class="fas fa-key mr-3 w-5 text-center"></i>
    <span>طلبات إعادة تعيين كلمة السر</span>
</x-nav-link>

                <x-nav-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.*')">
                    <i class="fas fa-chart-pie mr-3 w-5 text-center"></i>
                    <span>التقارير</span>
                </x-nav-link>
            </nav>

            <div class="mt-auto pt-4 border-t border-blue-700 dark:border-gray-700">
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>

                <script>
                const themeToggle = document.getElementById('theme-toggle');
                const html = document.documentElement;

                // تحقق من التفضيل المحفوظ
                if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }

                // تبديل الوضع
                themeToggle.addEventListener('click', () => {
                    html.classList.toggle('dark');
                    localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
                });
                </script>
                <x-nav-link href="#">
                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                    <span>الإعدادات</span>
                </x-nav-link>
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        @isset($header)
                            {{ $header }}
                        @else
                            @yield('header')
                        @endisset
                    </h1>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
