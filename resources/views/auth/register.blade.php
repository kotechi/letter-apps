<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter Apps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">
    <main class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center mb-6">Register</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full border-gray-300 rounded-lg mt-1 p-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                    Register
                </button>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </main>
    <footer class="bg-gray-200 text-center py-3 text-sm text-gray-600 mt-4">
        © {{ date('Y') }} Letter Apps. All rights reserved.
    </footer>
</body>
</html>
