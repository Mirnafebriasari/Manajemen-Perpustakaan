<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Manajemen Perpustakaan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<header class="bg-blue-700 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="font-bold text-lg">Perpustakaan Digital</a>
        <nav>
            @auth
                <span class="mr-4">Halo, {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
                <a href="{{ route('dashboard') }}" class="mr-4 hover:underline">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mr-4 hover:underline">Login</a>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
            @endauth
        </nav>
    </div>
</header>

<main class="container mx-auto flex-grow p-4">
    @yield('content')
</main>

<footer class="bg-gray-300 text-center p-4 mt-auto">
    &copy; {{ date('Y') }} Manajemen Perpustakaan Digital
</footer>

</body>
</html>
