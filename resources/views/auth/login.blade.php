<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Teras Mama Afi POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-900 via-slate-800 to-gray-900 min-h-screen flex items-center justify-center p-4 antialiased">
    
    <div class="w-full max-w-md bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl shadow-2xl p-8 overflow-hidden relative">
        <!-- Decorative blob -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <div class="text-center mb-10">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Teras Mama Afi Logo" class="h-24 w-auto object-contain rounded-xl shadow-lg ring-4 ring-white/10">
                </div>
                <p class="text-indigo-200 text-sm">Sign in to your POS account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-200 mb-1">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg bg-gray-900/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                    @error('username')
                        <p class="text-red-400 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg bg-gray-900/50 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                    @error('password')
                        <p class="text-red-400 text-xs mt-2 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-900 transition-all duration-200 transform hover:scale-[1.02]">
                    Sign In
                </button>
            </form>
            
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Teras Mama Afi POS. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>
