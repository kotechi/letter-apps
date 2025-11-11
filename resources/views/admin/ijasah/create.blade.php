<x-layouts.app title="Tambah izasah">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Tambah Data izasah</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.ijasah.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama') }}" 
                       class="w-full border border-blue-600 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan nama lengkap"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Asal Sekolah</label>
                <input type="text" 
                       name="asal_sekolah" 
                       value="{{ old('asal_sekolah') }}" 
                       class="w-full border border-blue-600 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan asal sekolah">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Masuk</label>
                <input type="date" 
                       name="tanggal_masuk" 
                       value="{{ old('tanggal_masuk') }}" 
                       class="w-full border border-blue-600 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" 
                          rows="4" 
                          class="w-full border border-blue-600 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Masukkan keterangan tambahan">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Simpan
                </button>
                <a href="{{ route('admin.ijasah.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
