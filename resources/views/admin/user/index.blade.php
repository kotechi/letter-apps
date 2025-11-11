<x-layouts.app title="User">
    <div class="w-full bg-white rounded-xl shadow-lg p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-1">Manajemen User</h2>
                <p class="text-sm text-gray-500">Kelola data pengguna sistem</p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 font-medium">
                <i class="fas fa-plus"></i>
                <span>Tambah User</span>
            </a>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table id="my-table" class="custom-table w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            ID
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Email
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $user->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="inline-flex items-center px-3 py-2 text-blue-600 border border-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form id="delete-form-{{ $user->id }}" 
                                          action="{{ route('admin.users.destroy', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button data-id="{{ $user->id }}" 
                                                type="button" 
                                                class="btn-delete inline-flex items-center px-3 py-2 text-red-600 border border-red-500 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200">
                                            <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-state">
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada user ditemukan</p>
                                    <p class="text-gray-400 text-sm mt-1">Silakan tambahkan user baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile & Tablet Card View -->
        <div class="lg:hidden space-y-4">
            @forelse ($users as $user)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4">
                    <!-- User Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-white font-bold text-lg">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 truncate">
                                    <i class="fas fa-envelope text-gray-400 mr-1"></i>{{ $user->email }}
                                </p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full flex-shrink-0 ml-2
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <!-- User Info -->
                    <div class="grid grid-cols-2 gap-3 mb-3 text-sm">
                        <div class="bg-gray-50 rounded-lg p-2">
                            <span class="text-gray-500 block text-xs">User ID</span>
                            <span class="text-gray-900 font-semibold">#{{ $user->id }}</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-2">
                            <span class="text-gray-500 block text-xs">Role</span>
                            <span class="text-gray-900 font-semibold capitalize">{{ $user->role }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-blue-600 border-2 border-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 font-medium">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>

                        <form id="delete-form-{{ $user->id }}" 
                              action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button data-id="{{ $user->id }}" 
                                    type="button" 
                                    class="btn-delete w-full inline-flex items-center justify-center px-4 py-2.5 text-red-600 border-2 border-red-500 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 font-medium">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg font-medium">Tidak ada user ditemukan</p>
                    <p class="text-gray-400 text-sm mt-2">Silakan tambahkan user baru</p>
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-plus"></i>
                        <span>Tambah User Pertama</span>
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination (if applicable) -->
        @if(method_exists($users, 'links'))
            <div class="mt-6 pt-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <style>
        /* Custom styles for better mobile experience */
        @media (max-width: 1023px) {
            .custom-table {
                display: none;
            }
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        /* Better touch targets for mobile */
        @media (max-width: 640px) {
            button, a {
                min-height: 44px;
            }
        }
    </style>
</x-layouts.app>