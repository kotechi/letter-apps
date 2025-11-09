<x-layouts.app title="Detail Ijasah">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Detail Data Ijasah</h2>
            <a href="{{ route('admin.ijasah.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div class="space-y-4">
            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">ID</label>
                <p class="text-lg">{{ $ijasah->id }}</p>
            </div>

            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                <p class="text-lg">{{ $ijasah->nama }}</p>
            </div>

            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Asal Sekolah</label>
                <p class="text-lg">{{ $ijasah->asal_sekolah ?? '-' }}</p>
            </div>

            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Masuk</label>
                <p class="text-lg">
                    {{ $ijasah->tanggal_masuk ? \Carbon\Carbon::parse($ijasah->tanggal_masuk)->format('d F Y') : '-' }}
                </p>
            </div>

            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Keterangan</label>
                <p class="text-lg whitespace-pre-line">{{ $ijasah->keterangan ?? '-' }}</p>
            </div>

            <div class="border-b pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Dibuat Pada</label>
                <p class="text-lg">{{ $ijasah->created_at ? $ijasah->created_at->format('d F Y H:i') : '-' }}</p>
            </div>

            <div class="pb-3">
                <label class="block text-sm font-medium text-gray-600 mb-1">Diupdate Pada</label>
                <p class="text-lg">{{ $ijasah->updated_at ? $ijasah->updated_at->format('d F Y H:i') : '-' }}</p>
            </div>
        </div>

        <div class="flex gap-2 mt-6">
            <a href="{{ route('admin.ijasah.edit', $ijasah->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
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
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition btn-delete">
                    Delete
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>