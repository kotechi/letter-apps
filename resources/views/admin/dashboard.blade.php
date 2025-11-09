<x-layouts.app tittle="dashboard">
    @php
        $schoolsCount = $schools->count();
        $siswaCount = $siswa->count();
        $usersCount = \App\Models\User::count();
    @endphp

    <div class="w-full  ml-2 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Dashboard</h2>

        <!-- Overview cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-blue-50 rounded-lg shadow-sm">
                <div class="text-sm text-gray-500">Sekolah</div>
                <div class="text-2xl font-bold text-blue-700">{{ $schoolsCount }}</div>
            </div>

            <div class="p-4 bg-green-50 rounded-lg shadow-sm">
                <div class="text-sm text-gray-500">Siswa</div>
                <div class="text-2xl font-bold text-green-700">{{ $siswaCount }}</div>
            </div>

            <div class="p-4 bg-yellow-50 rounded-lg shadow-sm">
                <div class="text-sm text-gray-500">Users</div>
                <div class="text-2xl font-bold text-yellow-700">{{ $usersCount }}</div>
            </div>
        </div>

        <!-- Button to open export modal -->
        <div class="flex items-center justify-between mb-4">

            <button id="openExportBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
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

                <form method="POST" action="{{ route('export.word.pindah') }}">
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

        @if (session('status'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <!-- Minimal JS for modal toggle -->
    <script>
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