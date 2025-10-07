
<x-layouts.app title="Create Siswa">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <h2 class="text-2xl font-bold text-blue-600 mb-6">Create Siswa</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border border-blue-600  p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Kelas</label>
                <input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full border-blue-600  border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full  border-blue-600 border p-2 rounded">
                    <option value="laki-laki" {{ old('jenis_kelamin')=='laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ old('jenis_kelamin')=='perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm">Asal Sekolah </label>
                <select  name="asal_sekolah"  class="w-full border border-blue-600  p-2 rounded">
                    @forelse ($schools as $schools)
                        <option value="{{ $schools->id }}">{{$schools->nama_sekolah}}</option>    
                    @empty
                        <option value=""><a href="{{ route('admin.school.create') }}"></a></option>
                    @endforelse
                </select>
            </div>
            <div>
                <label class="block text-sm">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" class="w-full border-blue-600  border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">NIS</label>
                <input type="text" name="nis" value="{{ old('nis') }}" class="w-full border-blue-600  border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border-blue-600  border p-2 rounded">
            </div>
            <div>
                <label class="block text-sm">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border-blue-600  border p-2 rounded">
            </div>

            <div>
                <button class="bg-blue-600 text-white px-4 py-2 border-blue-600  rounded">Save</button>
                <a href="{{ route('admin.siswa') }}" class="ml-2 text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.app>