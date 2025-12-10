<x-layouts.app title="Surat Masuk">
    <div class="w-full ml-2 bg-white rounded-lg shadow-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-blue-600">Daftar Surat Masuk</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola surat masuk dan lampiran siswa</p>
            </div>

            <a href="{{ route('admin.surat-masuk.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Tambah Surat Masuk
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <table id="my-table" class="min-w-full custom-table divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-50 text-blue-700">
                <tr>
                    <th data-sortable="true" class="py-3 px-3 text-left">#</th>
                    <th data-sortable="true" class="py-3 px-3 text-left">Nomor Surat</th>
                    <th data-sortable="true" class="py-3 px-3 text-left">Kepala Bidang</th>
                    <th data-sortable="true" class="py-3 px-3 text-left">Jml Lampiran</th>
                    <th data-sortable="true" class="py-3 px-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($suratMasuk as $surat)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-3">{{ $loop->iteration }}</td>
                        <td class="py-3 px-3">{{ $surat->nomor_surat }}</td>
                        <td class="py-3 px-3">{{ $surat->nama_kepala_bidang ?? '-' }}</td>
                        <td class="py-3 px-3">{{ $surat->lampiran_list->count() }}</td>
                        <td class="py-3 px-3 text-center space-x-5">
                            <a href="{{ route('admin.surat-masuk.show', $surat) }}"
                               class="inline-flex items-center gap-1 text-green-600 border border-green-500 px-2 py-1 rounded hover:bg-green-600 hover:text-white transition">
                                Detail
                            </a>
                            
                            <a href="{{ route('admin.surat-masuk.export', $surat) }}"
                               class="inline-flex items-center gap-1 text-purple-600 border border-purple-500 px-2 py-1 rounded hover:bg-purple-600 hover:text-white transition">
                                Export
                            </a>

                            @if($surat->file_pdf)
                                <a href="{{ route('admin.surat-masuk.download', ['suratMasuk' => $surat, 'type' => 'pdf']) }}"
                                   class="inline-flex items-center gap-1 text-red-600 border border-red-500 px-2 py-1 rounded hover:bg-red-600 hover:text-white transition">
                                    PDF
                                </a>
                            @endif
                            
                            <a href="{{ route('admin.surat-masuk.edit', $surat) }}"
                               class="inline-flex items-center gap-1 text-blue-600 border border-blue-500 px-2 py-1 rounded hover:bg-blue-600 hover:text-white transition">
                                Edit
                            </a>
                            <form id="delete-form-{{ $surat->id }}" action="{{ route('admin.surat-masuk.destroy', $surat) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button data-id="{{ $surat->id }}" 
                                        type="button" 
                                        class="text-red-600 btn-delete-surat rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-12">
                            <div class="space-y-2">
                                <div class="text-lg font-medium">Tidak ada surat masuk ditemukan</div>
                                <div class="text-sm text-gray-500">Tambah surat baru untuk mulai menambahkan data.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $suratMasuk->links() }}
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-delete-surat').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Hapus Surat Masuk?',
                    text: "Data surat dan semua lampiran akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            });
        });
    </script>
</x-layouts.app>
