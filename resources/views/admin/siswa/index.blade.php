<x-layouts.app title="Siswa">
    <div class="w-full bg-white rounded-xl shadow-lg p-4 sm:p-6 lg:p-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-4 border-b border-gray-200">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-1">Data Siswa</h2>
                <p class="text-sm text-gray-500">Kelola data siswa sekolah</p>
            </div>
            <a href="{{ route('admin.siswa.create') }}" 
               class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2.5 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 font-medium">
                <i class="fas fa-plus"></i>
                <span>Tambah Siswa</span>
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
                            Nama Siswa
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            NISN
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            NIS
                        </th>
                        <th data-sortable="true" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Asal Sekolah
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($siswa as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $item->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">{{ strtoupper(substr($item->nama, 0, 1)) }}</span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="fas fa-id-card text-gray-400 mr-2"></i>{{ $item->nisn }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="fas fa-id-badge text-gray-400 mr-2"></i>{{ $item->nis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="fas fa-school text-gray-400 mr-2"></i>{{ optional($item->school)->nama_sekolah ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.siswa.edit', $item) }}" 
                                       class="inline-flex items-center px-3 py-2 text-blue-600 border border-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form id="delete-form-{{ $item->id }}" 
                                          action="{{ route('admin.siswa.destroy', $item) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button data-id="{{ $item->id }}" 
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-graduation-cap text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada data siswa</p>
                                    <p class="text-gray-400 text-sm mt-1">Silakan tambahkan siswa baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile & Tablet Card View -->
        <div class="lg:hidden space-y-4">
            @forelse ($siswa as $item)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4">
                    <!-- Student Header -->
                    <div class="flex items-start mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <span class="text-white font-bold text-xl">{{ strtoupper(substr($item->nama, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->nama }}</h3>
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Kelas {{ $item->kelas }}
                            </span>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <span class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-id-card text-gray-400 mr-2 w-4"></i>
                                NISN
                            </span>
                            <span class="text-sm font-semibold text-gray-900">{{ $item->nisn }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <span class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-id-badge text-gray-400 mr-2 w-4"></i>
                                NIS
                            </span>
                            <span class="text-sm font-semibold text-gray-900">{{ $item->nis }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <span class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-school text-gray-400 mr-2 w-4"></i>
                                Asal Sekolah
                            </span>
                            <span class="text-sm font-semibold text-gray-900 text-right">
                                {{ optional($item->school)->nama_sekolah ?? '-' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <span class="text-sm text-gray-600 flex items-center">
                                <i class="fas fa-hashtag text-gray-400 mr-2 w-4"></i>
                                ID
                            </span>
                            <span class="text-sm font-semibold text-gray-900">#{{ $item->id }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.siswa.edit', $item) }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-blue-600 border-2 border-blue-500 rounded-lg hover:bg-blue-600 hover:text-white transition-all duration-200 font-medium">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>

                        <form id="delete-form-{{ $item->id }}" 
                              action="{{ route('admin.siswa.destroy', $item) }}" 
                              method="POST" 
                              class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button data-id="{{ $item->id }}" 
                                    type="button" 
                                    class="btn-delete w-full inline-flex items-center justify-center px-4 py-2.5 text-red-600 border-2 border-red-500 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-200 font-medium">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-graduation-cap text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg font-medium">Tidak ada data siswa</p>
                    <p class="text-gray-400 text-sm mt-2">Silakan tambahkan siswa baru</p>
                    <a href="{{ route('admin.siswa.create') }}" 
                       class="inline-flex items-center gap-2 mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Siswa Pertama</span>
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination (if applicable) -->
        @if(method_exists($siswa, 'links'))
            <div class="mt-6 pt-4 border-t border-gray-200">
                {{ $siswa->links() }}
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

        /* Ensure long text doesn't break layout */
        .text-right {
            word-break: break-word;
        }
    </style>
</x-layouts.app>