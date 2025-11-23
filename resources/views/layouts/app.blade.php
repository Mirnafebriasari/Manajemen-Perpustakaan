<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Manajemen Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

{{-- Transparent Navbar --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/10 backdrop-blur-md border-b border-white/20 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            {{-- Logo/Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30 group-hover:bg-white/30 transition-all duration-300">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold text-black drop-shadow-lg">Perpustakaan Digital</span>
            </a>

            {{-- Navigation Links --}}
            <nav class="hidden md:flex items-center gap-2">
                <a href="{{ route('home') }}" 
                   class="px-5 py-2 text-black font-medium rounded-lg hover:bg-white/20 transition-all duration-300 drop-shadow-md">
                    Beranda
                </a>
                
                @auth
                    {{-- User Info & Dropdown --}}
                    <div class="relative group ml-2">
                        <button class="flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-black font-medium rounded-lg hover:bg-white/30 transition-all duration-300 border border-white/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-md rounded-lg shadow-2xl border border-white/30 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Role: <span class="font-medium">{{ auth()->user()->getRoleNames()->first() ?? 'No Role' }}</span>
                                </p>
                            </div>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-2 px-4 py-3 text-gray-800 hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-2 w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-b-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-6 py-2 bg-white/90 backdrop-blur-sm text-gray-800 font-semibold rounded-lg hover:bg-white transition-all duration-300 shadow-lg ml-2">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-black font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-600 transition-all duration-300 shadow-lg">
                        Register
                    </a>
                @endauth
            </nav>

            {{-- Mobile Menu Button --}}
            <button class="md:hidden p-2 text-white" onclick="toggleMobileMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden md:hidden pb-4">
            <div class="flex flex-col gap-2">
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-300">
                    Beranda
                </a>
                
                @auth
                    <div class="px-4 py-2 text-white/80 text-sm border-t border-white/20 mt-2 pt-3">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-xs">{{ auth()->user()->getRoleNames()->first() ?? 'No Role' }}</p>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-300">
                        Dashboard
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-2 text-left text-red-300 font-medium rounded-lg hover:bg-white/20 transition-all duration-300">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-800 font-semibold rounded-lg hover:bg-white transition-all duration-300 text-center">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-600 transition-all duration-300 text-center">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{-- Main Content with padding-top to account for fixed navbar --}}
<main class="pt-20 container mx-auto px-4 mb-10">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="relative z-10 bg-gray-900/90 backdrop-blur-md text-white text-center py-6 mt-auto border-t border-white/10">
    <div class="container mx-auto px-4">
        <p class="text-sm">&copy; {{ date('Y') }} Manajemen Perpustakaan Digital. All rights reserved.</p>
        <p class="text-xs text-gray-400 mt-1">Powered by Laravel & Tailwind CSS</p>
    </div>
</footer>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('hidden');
}
</script>

</body>
</html>