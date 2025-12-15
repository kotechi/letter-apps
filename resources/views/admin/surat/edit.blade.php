<x-layouts.app title="Edit Surat">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Edit Surat</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.surats.update', $surat) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Informasi Surat --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Surat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Surat Keterangan</label>
                        <input type="text" name="no_surat_keterangan" 
                               value="{{ old('no_surat_keterangan', $surat->no_surat_keterangan) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Surat Asal</label>
                        <input type="text" name="no_surat_asal" 
                               value="{{ old('no_surat_asal', $surat->no_surat_asal) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" 
                               value="{{ old('tanggal_surat', $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d') : '') }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
            </div>

            {{-- Informasi Siswa --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Siswa</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Siswa <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" 
                               value="{{ old('nama', $surat->nama) }}" 
                               class="w-full border border-blue-600 p-2 rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" name="kelas" 
                               value="{{ old('kelas', $surat->kelas) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" name="nisn" 
                               value="{{ old('nisn', $surat->nisn) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIS</label>
                        <input type="text" name="nis" 
                               value="{{ old('nis', $surat->nis) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" 
                               value="{{ old('tempat_lahir', $surat->tempat_lahir) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" 
                               value="{{ old('tanggal_lahir', $surat->tanggal_lahir ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border border-blue-600 p-2 rounded">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Informasi Sekolah Asal --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Sekolah Asal</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Sekolah Asal</label>
                        <input type="text" name="asal_sekolah" 
                               value="{{ old('asal_sekolah', $surat->asal_sekolah) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Sekolah Asal</label>
                        <input type="text" name="alamat_sekolah_asal" 
                               value="{{ old('alamat_sekolah_asal', $surat->alamat_sekolah_asal) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
            </div>

            {{-- Informasi Sekolah Tujuan --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Sekolah Tujuan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Sekolah Tujuan</label>
                        <input type="text" name="nama_sekolah_tujuan" 
                               value="{{ old('nama_sekolah_tujuan', $surat->nama_sekolah_tujuan) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Sekolah Tujuan</label>
                        <input type="text" name="alamat_sekolah_tujuan" 
                               value="{{ old('alamat_sekolah_tujuan', $surat->alamat_sekolah_tujuan) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kota</label>
                        <input type="text" name="kota_sekolah_tujuan" 
                               value="{{ old('kota_sekolah_tujuan', $surat->kota_sekolah_tujuan) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi_sekolah_tujuan" 
                               value="{{ old('provinsi_sekolah_tujuan', $surat->provinsi_sekolah_tujuan) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
            </div>

            {{-- Informasi Kepala Sekolah --}}
            <div class="border-b border-gray-200 pb-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Pejabat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Pejabat</label>
                        <input type="text" name="nama_kepsek" 
                               value="{{ old('nama_kepsek', $surat->nama_kepsek) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIP Pejabat</label>
                        <input type="text" name="nip_kepsek" 
                               value="{{ old('nip_kepsek', $surat->nip_kepsek) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jabatan Pejabat</label>
                        <input type="text" name="jabatan_pejabat" 
                               value="{{ old('jabatan_pejabat', $surat->jabatan_pejabat) }}" 
                               class="w-full border border-blue-600 p-2 rounded">
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2 pt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Update
                </button>
                <a href="{{ route('admin.surats.show', $surat) }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>