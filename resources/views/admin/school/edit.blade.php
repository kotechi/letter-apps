<x-layouts.app title="Edit School">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Edit School</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.school.update', $school) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $school->nama_sekolah) }}" class="w-full border border-blue-600 p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Alamat</label>
                <textarea name="alamat" class="w-full border p-2 border-blue-600 rounded">{{ old('alamat', $school->alamat) }}</textarea>
            </div>
            <div>
                <label class="block text-sm">Kota/Kabupaten</label>
                <input type="text" name="kota" value="{{ old('kota', $school->kota) }}" class="w-full border p-2 border-blue-600 rounded">
            </div>
            <div>
                <label class="block text-sm">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $school->provinsi) }}" class="w-full border p-2 border-blue-600 rounded">
            </div>

            <div>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('admin.school') }}" class="ml-2 text-gray-600">Back</a>
            </div>
        </form>
    </div>
</x-layouts.app>