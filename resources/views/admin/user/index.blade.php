<x-layouts.app title="User">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">User</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Create User
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="table" class="table table-striped table-bordered w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="capitalize">{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-blue-600 mr-2 rounded-md px-3 py-1 border border-blue-500 hover:bg-blue-600 hover:text-white transition">
                                    Edit
                                </a>

                                <form id="delete-form-{{ $user->id }}" 
                                      action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-id="{{ $user->id }}" 
                                            type="button" 
                                            class="text-red-600 btn-delete rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-6">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>
