<x-layouts.app title="Tambah Surat Masuk">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Tambah Surat Masuk</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 
        <form action="{{ route('admin.surat-masuk.store') }}" method="POST" class="space-y-6" id="formSuratMasuk">
            @csrf

            {{-- Informasi Surat --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Surat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Masehi <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_masehi" value="{{ old('tanggal_masehi') }}" required
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Hijriah <span class="text-red-500">*</span></label>
                        <input type="text" name="tanggal_hijriah" value="{{ old('tanggal_hijriah') }}" required
                               placeholder="Contoh: 15 Ramadhan 1445"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Surat <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}" required
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lampiran (text)</label>
                        <input type="text" name="lampiran_text" value="{{ old('lampiran_text') }}"
                               placeholder="Contoh: 5 Lembar"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Surat Saudara</label>
                        <input type="text" name="nomor_surat_saudara" value="{{ old('nomor_surat_saudara') }}"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Permohonan</label>
                        <input type="date" name="tanggal_permohonan" value="{{ old('tanggal_permohonan') }}"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kepala Bidang</label>
                        <input type="text" name="nama_kepala_bidang" value="{{ old('nama_kepala_bidang') }}"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP Kepala Bidang</label>
                        <input type="text" name="nip_kepala_bidang" value="{{ old('nip_kepala_bidang') }}"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Yth. Nama Sekolah Tujuan</label>
                        <input type="text" name="yth_nama_sekolah_tujuan" value="{{ old('yth_nama_sekolah_tujuan') }}"
                               placeholder="Contoh: Kepala Sekolah Dasar (SD) Negeri Loji 2"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Yth. Alamat Sekolah Tujuan</label>
                        <input type="text" name="yth_alamat_sekolah_tujuan" value="{{ old('yth_alamat_sekolah_tujuan') }}"
                               placeholder="Contoh: Jl. Raya Pendidikan No. 123, Jakarta Selatan"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Nama Sekolah Tujuan</label>
                        <input type="text" name="nama_sekolah_tujuan" value="{{ old('nama_sekolah_tujuan') }}"
                               placeholder="Contoh: SMK Negeri 1 Jakarta"
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
            </div>

            {{-- Lampiran Section --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Lampiran Surat</h3>
                
                <div id="containerLampiran" class="space-y-4">
                    <!-- Lampiran will be here -->
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.surat-masuk.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function renderLampiran() {
            const container = document.getElementById('containerLampiran');
            const lampiranIndex = 0; // Hanya 1 lampiran dengan index 0
            
            const lampiranDiv = document.createElement('div');
            lampiranDiv.className = 'border border-gray-300 rounded p-4';
            
            lampiranDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Lampiran <span class="text-red-500">*</span></label>
                        <input type="text" name="lampiran[${lampiranIndex}][nomor_lampiran]" required
                               class="w-full border border-blue-600 p-2 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lampiran <span class="text-red-500">*</span></label>
                        <input type="date" name="lampiran[${lampiranIndex}][tanggal_lampiran]" required
                               class="w-full border border-blue-600 p-2 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kepala Bidang Lampiran</label>
                        <input type="text" name="lampiran[${lampiranIndex}][nama_kabid_lampiran]"
                               class="w-full border border-blue-600 p-2 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP Kepala Bidang Lampiran</label>
                        <input type="text" name="lampiran[${lampiranIndex}][nip_kabid_lampiran]"
                               class="w-full border border-blue-600 p-2 rounded text-sm">
                    </div>
                </div>

                <div class="border-t pt-3">
                    <div class="flex justify-between items-center mb-2">
                        <h5 class="font-medium text-gray-600 text-sm">Daftar Siswa</h5>
                        <button type="button" class="btn-tambah-siswa bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600"
                                data-lampiran="${lampiranIndex}">
                            + Tambah Siswa
                        </button>
                    </div>
                    <div class="siswa-container-${lampiranIndex} space-y-2">
                        <!-- Siswa items will be added here -->
                    </div>
                </div>
            `;
            
            container.appendChild(lampiranDiv);
            
            // Event listener untuk tambah siswa
            lampiranDiv.querySelector('.btn-tambah-siswa').addEventListener('click', function() {
                tambahSiswa(lampiranIndex);
            });
        }

        function tambahSiswa(lampiranIndex) {
            const container = document.querySelector(`.siswa-container-${lampiranIndex}`);
            const siswaIndex = container.children.length;
            
            const siswaDiv = document.createElement('div');
            siswaDiv.className = 'bg-gray-50 p-3 rounded border border-gray-200 siswa-item';
            
            siswaDiv.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs font-medium text-gray-600">Siswa #${siswaIndex + 1}</span>
                    <button type="button" class="btn-hapus-siswa text-red-500 hover:text-red-700 text-xs">
                        <i class="fas fa-times"></i> Hapus
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs text-gray-600">Nama Siswa <span class="text-red-500">*</span></label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][nama_siswa]" required
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">Tempat Lahir</label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][tempat_lahir]"
                               placeholder="Jakarta"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">Tanggal Lahir</label>
                        <input type="date" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][tanggal_lahir]"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">NISN</label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][nisn]"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">Kelas Masuk</label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][kelas_masuk]"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">Tahun Masuk</label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][tahun_masuk]"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600">Asal Sekolah</label>
                        <input type="text" name="lampiran[${lampiranIndex}][siswa][${siswaIndex}][asal_sekolah]"
                               class="w-full border border-gray-300 p-1 rounded text-sm">
                    </div>
                </div>
            `;
            
            container.appendChild(siswaDiv);
            
            // Event listener untuk hapus siswa
            siswaDiv.querySelector('.btn-hapus-siswa').addEventListener('click', function() {
                siswaDiv.remove();
                updateSiswaNumbers(lampiranIndex);
            });
        }

        function updateSiswaNumbers(lampiranIndex) {
            const siswaItems = document.querySelectorAll(`.siswa-container-${lampiranIndex} .siswa-item`);
            siswaItems.forEach((item, index) => {
                item.querySelector('span').textContent = `Siswa #${index + 1}`;
            });
        }

        // Render lampiran saat halaman load
        window.addEventListener('DOMContentLoaded', function() {
            renderLampiran();
        });
    </script>
</x-layouts.app>
