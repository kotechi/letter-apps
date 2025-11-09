<x-layouts.app title="Surat">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Daftar Surat Pindah Sekolah</h2>

            <!-- Button to open export modal -->
            <div class="flex items-center justify-between mb-4">

                <form action="{{ route('admin.surats.destroyall') }}" method="POST" class="inline" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteAllBtn"
                            class="text-white bg-red-600 rounded-md px-3 py-2 border border-red-500 hover:bg-white hover:text-red-600 transition">
                        Hapus Semua
                    </button>
                </form>
                <button id="openExportBtn" class="bg-blue-600 mt text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Buat Surat Pindah Sekolah
                </button>
                
            </div>

            <!-- Modal: Export Form -->
            <div id="exportModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                <!-- overlay -->
                <div id="modalOverlay" class="absolute inset-0 bg-black opacity-50"></div>

                <div class="bg-white rounded-lg shadow-lg z-10 w-full max-w-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl text-blue-600 font-semibold">Buat Surat Pindah Sekolah</h3>
                        <button id="closeExportBtn" class="text-gray-600 hover:text-gray-800">&times;</button>
                    </div>

                    <form method="POST" action="{{ route('admin.surats.export') }}" id="formExport">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm mb-1">Sekolah Tujuan</label>
                            <select name="sekolah_id" class="w-full border border-blue-600 rounded px-3 py-2">
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm mb-1">Siswa</label>
                            <select name="siswa_id" class="w-full border rounded border-blue-600 px-3 py-2">
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm mb-1">No Surat Asal</label>
                            <input type="text" name="no_surat_asal" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm mb-1">No Surat Keterangan</label>
                            <input type="number" name="no_surat_keterangan" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm mb-1">Nama Kepsek dan Gelar nya</label>
                            <input type="text" name="nama_kepsek" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm mb-1">NIP Kepsek</label>
                            <input type="number" name="nip_kepsek" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>

                        <div class="flex justify-end">
                            <button type="button" id="cancelExport" class="mr-2 px-4 py-2 rounded border">Cancel</button>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Buat Surat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Filter Form --}}
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <form method="GET" action="{{ route('admin.surats') }}" class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}"
                           class="w-full border border-gray-300 p-2 rounded">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.surats') }}"
                       class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabel Surat --}}
        <div class="overflow-x-auto">
            <table id="table" class="w-full border table border-gray-200 text-sm">
                <thead class="bg-blue-50 text-blue-700">
                    <tr class="text-center">
                        <th class="py-3 px-1 text-center border-b">#</th>
                        <th class="p-3 text-center border-b">Tanggal Surat</th>
                        <th class="p-3 text-center border-b">Nama Siswa</th>
                        <th class="p-3 text-center border-b">Kelas</th>
                        <th class="p-3 text-center border-b">nisn</th>
                        <th class="p-3 text-center border-b">Sekolah Tujuan</th>
                        <th class="p-3 text-center border-b">No Surat</th>
                        <th class="p-3 text-center border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-1 border-b">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b">{{ $surat->tanggal_surat}}</td>
                            <td class="p-3 border-b">{{ $surat->nama }}</td>
                            <td class="p-3 border-b">{{ $surat->kelas }}</td>
                            <td class="p-3 border-b">{{ $surat->nisn }}</td>
                            <td class="p-3 border-b">{{ $surat->nama_sekolah_tujuan }}</td>
                            <td class="p-3 border-b">{{ $surat->no_surat_keterangan ?? '-' }}</td>
                            <td class="p-3 text-center border-b space-x-1">
                                <a href="{{ route('admin.surats.show', $surat) }}"
                                   class="text-green-600 border border-green-500 px-2 py-1 rounded hover:bg-green-600 hover:text-white transition">
                                    Detail
                                </a>

                                @if($surat->file_pdf)
                                    <a href="{{ route('admin.surats.download', ['surat' => $surat->id, 'type' => 'pdf']) }}"
                                       class="text-purple-600 border border-purple-500 px-2 py-1 rounded hover:bg-purple-600 hover:text-white transition">
                                        PDF
                                    </a>
                                @endif

                                @if($surat->file_docx)
                                    <a href="{{ route('admin.surats.download', ['surat' => $surat->id, 'type' => 'docx']) }}"
                                       class="text-indigo-600 border border-indigo-500 px-2 py-1 rounded hover:bg-indigo-600 hover:text-white transition">
                                        download
                                    </a>
                                @endif

                                <form id="delete-form-{{ $surat->id }}" action="{{ route('admin.surats.destroy', $surat) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-id="{{ $surat->id }}" 
                                            type="button" 
                                            class="text-red-600 btn-delete rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-6">
                                Tidak ada surat ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $surats->links() }}
        </div>
    </div>
        <script>
        document.getElementById('deleteAllBtn')?.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Semua Surat?',
                text: "Semua surat dan file terkait akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    document.getElementById('deleteAllForm').submit();
                }
            });
        });
        document.getElementById('formExport').addEventListener('submit', function() {
            setTimeout(() => {
                location.reload(); 
            }, 1000);
        });
        (function () {
            const openBtn = document.getElementById('openExportBtn');
            const modal = document.getElementById('exportModal');
            const overlay = document.getElementById('modalOverlay');
            const closeBtn = document.getElementById('closeExportBtn');
            const cancelBtn = document.getElementById('cancelExport');

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function closeModal() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }

            if (openBtn) openBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
            if (overlay) overlay.addEventListener('click', closeModal);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();
    </script>
</x-layouts.app>
