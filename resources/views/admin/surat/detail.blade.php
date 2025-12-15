<x-layouts.app title="Detail Surat">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Detail Surat</h2>

        <div class="space-y-4">
            {{-- Informasi Surat --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Surat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">No. Surat Keterangan</label>
                        <p class="text-gray-800">{{ $surat->no_surat_keterangan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">No. Surat Asal</label>
                        <p class="text-gray-800">{{ $surat->no_surat_asal ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tanggal Surat</label>
                        <p class="text-gray-800">{{ $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->locale('id')->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi Siswa --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Siswa</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama</label>
                        <p class="text-gray-800">{{ $surat->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Kelas</label>
                        <p class="text-gray-800">{{ $surat->kelas ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">NISN</label>
                        <p class="text-gray-800">{{ $surat->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">NIS</label>
                        <p class="text-gray-800">{{ $surat->nis ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tempat, Tanggal Lahir</label>
                        <p class="text-gray-800">{{ $surat->tempat_lahir ?? '-' }}, {{ $surat->tanggal_lahir ? \Carbon\Carbon::parse($surat->tanggal_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <p class="text-gray-800">{{ $surat->jenis_kelamin ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi Sekolah Asal --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Sekolah Asal</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Sekolah</label>
                        <p class="text-gray-800">{{ $surat->asal_sekolah ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p class="text-gray-800">{{ $surat->alamat_sekolah_asal ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi Sekolah Tujuan --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Sekolah Tujuan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Sekolah</label>
                        <p class="text-gray-800">{{ $surat->nama_sekolah_tujuan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p class="text-gray-800">{{ $surat->alamat_sekolah_tujuan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Kota</label>
                        <p class="text-gray-800">{{ $surat->kota_sekolah_tujuan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Provinsi</label>
                        <p class="text-gray-800">{{ $surat->provinsi_sekolah_tujuan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Informasi Kepala Sekolah --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Pejabat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Pejabat</label>
                        <p class="text-gray-800">{{ $surat->nama_kepsek ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">NIP Pejabat</label>
                        <p class="text-gray-800">{{ $surat->nip_kepsek ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Jabatan Pejabat</label>
                        <p class="text-gray-800">{{ $surat->jabatan_pejabat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- File Downloads --}}
            <div class="pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Dokumen</h3>
                
                <div class="flex gap-3">
                    @if($surat->file_pdf)
                        <a href="{{ route('admin.surats.download', ['surat' => $surat, 'type' => 'pdf']) }}" 
                           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Download PDF
                        </a>
                    @endif
                    
                    @if($surat->file_docx)
                        <a href="{{ route('admin.surats.download', ['surat' => $surat, 'type' => 'docx']) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Download DOCX
                        </a>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2 pt-4">
                <a href="{{ route('admin.surats.edit', $surat) }}" 
                   class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                    Edit
                </a>
                <a href="{{ route('admin.surats') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>