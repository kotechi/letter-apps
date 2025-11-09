<x-layouts.app tittle="dashboard">
    <div class="w-full  ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Profile</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            @php $user = auth()->user(); @endphp

            <div>
                <label class="block text-sm">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-blue-600 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-blue-600 p-2 rounded">
            </div>

            <div>
                <label class="block text-sm">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="w-full border p-2 border-blue-600 rounded" autocomplete="new-password">
            </div>

            <div>
                <label class="block text-sm">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full border-blue-600 border p-2 rounded" autocomplete="new-password">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
                <a href="javascript:history.back()" class="ml-2 text-gray-600">Cancel</a>
            </div>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            You are logged in!
        </p>
    </div>
</x-layouts.app>