<x-layouts.app tittle="dashboard">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Dashboard</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <p class="text-center text-sm text-gray-600 mt-4">
            You are logged in!
        </p>
    </div>
</x-layouts.app>