<x-layouts.app title="Ijasah">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Data Ijasah</h2>
            <a href="{{ route('admin.ijasah.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Tambah Ijasah
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="table" class="table table-striped table-bordered w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Asal Sekolah</th>
                        <th>Tanggal Masuk</th>
                        <th>Keterangan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ijasahs as $ijasah)
                        <tr>
                            <td>{{ $ijasah->id }}</td>
                            <td>{{ $ijasah->nama }}</td>
                            <td>{{ $ijasah->asal_sekolah ?? '-' }}</td>
                            <td>{{ $ijasah->tanggal_masuk ? \Carbon\Carbon::parse($ijasah->tanggal_masuk)->format('d/m/Y') : '-' }}</td>
                            <td>{{ Str::limit($ijasah->keterangan ?? '-', 50) }}</td>
                            <td>
                                <a href="{{ route('admin.ijasah.show', $ijasah->id) }}" 
                                   class="text-green-600 mr-2 rounded-md px-3 py-1 border border-green-500 hover:bg-green-600 hover:text-white transition">
                                    Detail
                                </a>
                                
                                <a href="{{ route('admin.ijasah.edit', $ijasah->id) }}" 
                                   class="text-blue-600 mr-2 rounded-md px-3 py-1 border border-blue-500 hover:bg-blue-600 hover:text-white transition">
                                    Edit
                                </a>

                                <form id="delete-form-{{ $ijasah->id }}" 
                                      action="{{ route('admin.ijasah.destroy', $ijasah->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-id="{{ $ijasah->id }}" 
                                            type="button" 
                                            class="text-red-600 btn-delete rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6">Tidak ada data ijasah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>