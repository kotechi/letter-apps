<x-layouts.app tittle="edit user">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Edit User</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-blue-600  p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-blue-600  border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Password (leave blank to keep)</label>
                <input type="password" name="password" class="w-full border border-blue-600  p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-blue-600  p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Role</label>
                <select name="role" class="w-full border  border-blue-600 p-2 rounded">
                    <option value="user" {{ old('role', $user->role)=='user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role)=='admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('admin.users') }}" class="ml-2 text-gray-600">Back</a>
            </div>
        </form>
    </div>
</x-layouts.app>