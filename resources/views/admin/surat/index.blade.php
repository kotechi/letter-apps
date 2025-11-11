<x-layouts.app title="Surat">
    @php
        // safe helpers if $surats is paginator
        $totalSurats = isset($surats) && method_exists($surats, 'total') ? $surats->total() : (isset($surats) ? $surats->count() : 0);
        $currentCount = isset($surats) ? $surats->count() : 0;
    @endphp

    <div class="w-full ml-2 bg-white rounded-lg shadow-lg p-6">
        <!-- Header / Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-blue-600">Daftar Surat Pindah Sekolah</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola surat pindah — buat, download, atau hapus.</p>
            </div>

            <div class="flex items-center gap-3">

                <form action="{{ route('admin.surats.destroyall') }}" method="POST" class="inline" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteAllBtn" aria-label="Hapus Semua"
                            class="text-white bg-red-600 rounded-md px-3 py-2 border border-red-500 hover:bg-white hover:text-red-600 transition">
                        Hapus Semua
                    </button>
                </form>

                <button id="openExportBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Buat Surat Pindah
                </button>
            </div>
        </div>

        <!-- Summary cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-blue-50 rounded-lg shadow-sm">
                <div class="text-xs text-gray-500">Total Surat</div>
                <div class="text-xl font-semibold text-blue-700">{{ $totalSurats }}</div>
                <div class="text-xs text-gray-400 mt-1">Menampilkan {{ $currentCount }} item pada halaman ini</div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-sm border">
                <div class="text-xs text-gray-500">Filter & Cari</div>
                <div class="mt-2">
                    <form id="filterForm" method="GET" action="{{ route('admin.surats') }}" class="flex gap-2">
                        <input type="search" name="q" placeholder="Cari nama / NISN / no surat" value="{{ request('q') }}"
                               class="w-full border border-gray-300 p-2 rounded" />
                        <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition">Cari</button>
                    </form>
                </div>
            </div>

            <div class="p-4 bg-white rounded-lg shadow-sm border flex flex-col justify-between">
                <div class="text-xs text-gray-500">Tampilan</div>
                <div class="mt-2 flex items-center gap-2">
                    <label class="text-sm text-gray-600">Per halaman</label>
                    <form id="perPageForm" method="GET" action="{{ route('admin.surats') }}">
                        <select name="per_page" onchange="document.getElementById('perPageForm').submit()" class="border border-gray-300 p-2 rounded">
                            <option value="10" {{ request('per_page')=='10' ? 'selected':'' }}>10</option>
                            <option value="25" {{ request('per_page')=='25' ? 'selected':'' }}>25</option>
                            <option value="50" {{ request('per_page')=='50' ? 'selected':'' }}>50</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Export Form -->
        <div id="exportModal" class="fixed inset-0 z-50 hidden items-center justify-center">
            <!-- overlay -->
            <div id="modalOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            <div class="bg-white rounded-lg shadow-2xl z-10 w-full max-w-2xl p-6 mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl text-blue-600 font-semibold">Buat Surat Pindah Sekolah</h3>
                    <button id="closeExportBtn" aria-label="Tutup" class="text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.surats.export') }}" id="formExport" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm mb-1">Sekolah Tujuan</label>
                            <select name="sekolah_id" class="w-full border border-blue-600 rounded px-3 py-2">
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Siswa</label>
                            <select name="siswa_id" class="w-full border rounded border-blue-600 px-3 py-2">
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }} — {{ $s->nisn ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm mb-1">No Surat Asal</label>
                            <input type="text" name="no_surat_asal" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">No Surat Keterangan</label>
                            <input type="text" name="no_surat_keterangan" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm mb-1">Nama Kepsek dan Gelar</label>
                            <input type="text" name="nama_kepsek" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">NIP Kepsek</label>
                            <input type="text" name="nip_kepsek" required class="w-full border border-blue-600 rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" id="cancelExport" class="px-4 py-2 rounded border">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Buat Surat</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filters summary -->
        <div class="mb-4 text-sm text-gray-500">
            Menampilkan <strong>{{ $currentCount }}</strong> dari <strong>{{ $totalSurats }}</strong> surat.
        </div>

        <!-- Tabel Surat -->
        <div class="overflow-x-auto bg-white border rounded-lg shadow-sm">
            <table id="table" class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-blue-50 text-blue-700 min-w-full">
                    <tr>
                        <th class="py-3 px-3 text-left">#</th>
                        <th class="py-3 px-3 text-left">Tanggal Surat</th>
                        <th class="py-3 px-3 text-left">Nama Siswa</th>
                        <th class="py-3 px-3 text-left">Kelas</th>
                        <th class="py-3 px-3 text-left">NISN</th>
                        <th class="py-3 px-3 text-left">Sekolah Tujuan</th>
                        <th class="py-3 px-3 text-left">No Surat</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($surats as $surat)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-3">{{ $loop->iteration }}</td>
                            <td class="py-3 px-3">{{ $surat->tanggal_surat }}</td>
                            <td class="py-3 px-3">{{ $surat->nama }}</td>
                            <td class="py-3 px-3">{{ $surat->kelas }}</td>
                            <td class="py-3 px-3">{{ $surat->nisn }}</td>
                            <td class="py-3 px-3">{{ $surat->nama_sekolah_tujuan }}</td>
                            <td class="py-3 px-3">{{ $surat->no_surat_keterangan ?? '-' }}</td>
                            <td class="py-3 px-3 text-center space-x-1">
                                <a href="{{ route('admin.surats.show', $surat) }}"
                                   class="inline-flex items-center gap-1 text-green-600 border border-green-500 px-2 py-1 rounded hover:bg-green-600 hover:text-white transition">
                                    Detail
                                </a>

                                @if($surat->file_pdf)
                                    <a href="{{ route('admin.surats.download', ['surat' => $surat->id, 'type' => 'pdf']) }}"
                                       class="inline-flex items-center gap-1 text-purple-600 border border-purple-500 px-2 py-1 rounded hover:bg-purple-600 hover:text-white transition">
                                        PDF
                                    </a>
                                @endif

                                @if($surat->file_docx)
                                    <a href="{{ route('admin.surats.download', ['surat' => $surat->id, 'type' => 'docx']) }}"
                                       class="inline-flex items-center gap-1 text-indigo-600 border border-indigo-500 px-2 py-1 rounded hover:bg-indigo-600 hover:text-white transition">
                                        DOCX
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
                            <td colspan="8" class="text-center text-gray-500 py-12">
                                <div class="space-y-2">
                                    <svg class="mx-auto w-20 h-20 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 3h8l2 4H6l2-4z" />
                                    </svg>
                                    <div class="text-lg font-medium">Tidak ada surat ditemukan</div>
                                    <div class="text-sm text-gray-500">Buat surat baru untuk mulai menambahkan data.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                Menampilkan halaman {{ $surats->currentPage() ?? 1 }} 
                dari {{ $surats->lastPage() ?? 1 }}
            </div>
            <div>
                {{ $surats->links() }}
            </div>
        </div>
    </div>

    <script>
        // Safely wire up listeners only if elements exist
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
                    document.getElementById('deleteAllForm')?.submit();
                }
            });
        });

        // reload after export submit (if form exists)
        document.getElementById('formExport')?.addEventListener('submit', function() {
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
                modal?.classList.remove('hidden');
                modal?.classList.add('flex');
                // lock scroll
                document.documentElement.style.overflow = 'hidden';
            }
            function closeModal() {
                modal?.classList.remove('flex');
                modal?.classList.add('hidden');
                document.documentElement.style.overflow = '';
            }

            openBtn?.addEventListener('click', openModal);
            closeBtn?.addEventListener('click', closeModal);
            cancelBtn?.addEventListener('click', closeModal);
            overlay?.addEventListener('click', closeModal);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();
    </script>
</x-layouts.app>