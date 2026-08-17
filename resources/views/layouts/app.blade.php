<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Teras Mama Afi POS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-6">
                    <a href="/" class="flex items-center mr-4">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Teras Mama Afi Logo" class="h-10 w-auto object-contain rounded">
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">Dashboard</a>
                    <a href="{{ route('menus.index') }}" class="text-sm font-medium {{ request()->routeIs('menus.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">Menu</a>
                    <a href="{{ route('transactions.index') }}" class="text-sm font-medium {{ request()->routeIs('transactions.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">Kasir</a>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('reports.index') }}" class="text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">Laporan</a>
                    <a href="{{ route('forecasts.index') }}" class="text-sm font-medium {{ request()->routeIs('forecasts.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">Peramalan</a>
                    @endif
                    @endauth
                </div>
                <div class="flex items-center">
                    @auth
                    <span class="mr-4 text-sm font-medium text-gray-700">Hi, {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors">
                            Logout
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
        @yield('content')
    </main>
</body>
</html>
