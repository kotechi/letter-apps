<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel App') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between">
            <h1 class="text-xl font-semibold text-gray-800">MyApp</h1>
            @auth
                <a href="{{ route('logout') }}" class="text-red-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @endauth
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center">
        {{ $slot }}
    </main>

    <footer class="bg-gray-200 text-center py-3 text-sm text-gray-600">
        © {{ date('Y') }} MyApp. All rights reserved.
    </footer>

</body>
</html>
