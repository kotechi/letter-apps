<x-layouts.app title="Detail Surat Masuk">
    <div class="w-full ml-2 bg-white rounded-lg shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Detail Surat Masuk</h2>
            <a href="{{ route('admin.surat-masuk.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        {{-- Informasi Surat Utama --}}
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center gap-2">
                <i class="fas fa-envelope"></i>
                Informasi Surat
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Masehi</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->tanggal_masehi->format('d F Y') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Hijriah</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->tanggal_hijriah }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Surat</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->nomor_surat }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Lampiran (Text)</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->lampiran ?? '-' }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Surat Saudara</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->nomor_surat_saudara ?? '-' }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Permohonan</label>
                    <p class="text-gray-800 font-semibold">
                        {{ $suratMasuk->tanggal_permohonan ? $suratMasuk->tanggal_permohonan->format('d F Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Informasi Kepala Bidang --}}
        <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-600 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-green-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user-tie"></i>
                Kepala Bidang
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Kepala Bidang</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->nama_kepala_bidang ?? '-' }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">NIP Kepala Bidang</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->nip_kepala_bidang ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Informasi Tujuan Surat (Yth) --}}
        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 border-l-4 border-indigo-600 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-indigo-800 mb-4 flex items-center gap-2">
                <i class="fas fa-building"></i>
                Tujuan Surat (Yth)
            </h3>
            
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Yth. Nama Sekolah Tujuan</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->yth_nama_sekolah_tujuan ?? '-' }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Yth. Alamat Sekolah Tujuan</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->yth_alamat_sekolah_tujuan ?? '-' }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Sekolah Tujuan</label>
                    <p class="text-gray-800 font-semibold">{{ $suratMasuk->nama_sekolah_tujuan ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Daftar Lampiran --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-paperclip"></i>
                Daftar Lampiran ({{ $suratMasuk->lampiran_list->count() }})
            </h3>

            @forelse($suratMasuk->lampiran_list as $lampiran)
                <div class="border border-gray-300 rounded-lg p-6 mb-4 hover:shadow-lg transition">
                    {{-- Header Lampiran --}}
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 border-l-4 border-purple-600 rounded-lg p-4 mb-4">
                        <h4 class="text-lg font-bold text-purple-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Lampiran #{{ $loop->iteration }}
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nomor Lampiran</label>
                                <p class="text-gray-800 font-semibold text-sm">{{ $lampiran->nomor_lampiran }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Lampiran</label>
                                <p class="text-gray-800 font-semibold text-sm">{{ $lampiran->tanggal_lampiran->format('d F Y') }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Nama Kabid</label>
                                <p class="text-gray-800 font-semibold text-sm">{{ $lampiran->nama_kabid_lampiran ?? '-' }}</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <label class="block text-xs font-medium text-gray-500 mb-1">NIP Kabid</label>
                                <p class="text-gray-800 font-semibold text-sm">{{ $lampiran->nip_kabid_lampiran ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Siswa dalam Lampiran --}}
                    <div>
                        <h5 class="text-md font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-users"></i>
                            Daftar Siswa ({{ $lampiran->daftarSiswa->count() }})
                        </h5>

                        @if($lampiran->daftarSiswa->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                                    <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                                        <tr>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">No</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Nama Siswa</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Tempat Lahir</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Tanggal Lahir</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Kelas Masuk</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Tahun Masuk</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">Asal Sekolah</th>
                                            <th class="py-3 px-4 text-left text-xs font-semibold uppercase">NISN</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($lampiran->daftarSiswa as $siswa)
                                            <tr class="hover:bg-blue-50 transition">
                                                <td class="py-3 px-4 text-sm">{{ $siswa->no }}</td>
                                                <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $siswa->nama_siswa }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->tempat_lahir ?? '-' }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->locale('id')->translatedFormat('j F Y') : '-' }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->kelas_masuk ?? '-' }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->tahun_masuk ?? '-' }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->asal_sekolah ?? '-' }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-700">{{ $siswa->nisn ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">Tidak ada siswa dalam lampiran ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <i class="fas fa-folder-open text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-lg font-medium">Tidak ada lampiran ditemukan</p>
                    <p class="text-gray-400 text-sm mt-1">Surat ini belum memiliki lampiran</p>
                </div>
            @endforelse
        </div>

        {{-- File Downloads --}}
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-600 rounded-lg p-6">
            <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center gap-2">
                <i class="fas fa-download"></i>
                Dokumen Surat
            </h3>
            
            <div class="flex flex-wrap gap-3">
                @if($suratMasuk->file_pdf)
                    <a href="{{ route('admin.surat-masuk.download', ['suratMasuk' => $suratMasuk, 'type' => 'pdf']) }}" 
                       class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-file-pdf text-lg"></i>
                        <span class="font-semibold">Download PDF</span>
                    </a>
                @endif
                
                @if($suratMasuk->file_docx)
                    <a href="{{ route('admin.surat-masuk.download', ['suratMasuk' => $suratMasuk, 'type' => 'docx']) }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-file-word text-lg"></i>
                        <span class="font-semibold">Download DOCX</span>
                    </a>
                @endif

                @if(!$suratMasuk->file_pdf && !$suratMasuk->file_docx)
                    <div class="bg-white border border-yellow-300 rounded-lg p-4 text-yellow-700 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Belum ada file yang di-generate. Silakan export terlebih dahulu.</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.surat-masuk.edit', $suratMasuk) }}" 
               class="inline-flex items-center gap-2 bg-yellow-500 text-white px-5 py-3 rounded-lg hover:bg-yellow-600 transition shadow-md hover:shadow-lg">
                <i class="fas fa-edit"></i>
                <span class="font-semibold">Edit Surat</span>
            </a>

            <form action="{{ route('admin.surat-masuk.destroy', $suratMasuk) }}" method="POST" class="inline" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="button" id="deleteBtn"
                        class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-trash"></i>
                    <span class="font-semibold">Hapus Surat</span>
                </button>
            </form>

            <a href="{{ route('admin.surat-masuk.index') }}" 
               class="inline-flex items-center gap-2 bg-gray-500 text-white px-5 py-3 rounded-lg hover:bg-gray-600 transition shadow-md hover:shadow-lg">
                <i class="fas fa-arrow-left"></i>
                <span class="font-semibold">Kembali</span>
            </a>
        </div>
    </div>

    <script>
        document.getElementById('deleteBtn')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Hapus Surat Masuk?',
                text: "Data surat dan semua lampiran akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        });
    </script>
</x-layouts.app>
