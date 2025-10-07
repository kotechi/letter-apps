
<x-layouts.app title="Siswa">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Siswa</h2>
            <a href="{{ route('admin.siswa.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Create Siswa
            </a>
        </div>

        <div class="overflow-x-auto">
            <table id="table" class="table table-striped table-bordered w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>NISN</th>
                        <th>NIS</th>
                        <th>Asal Sekolah</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ optional($item->school)->nama_sekolah ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.siswa.edit', $item) }}" class="text-blue-600 mr-2 rounded-md px-3 py-1 border border-blue-500 hover:bg-blue-600 hover:text-white transition">Edit</a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.siswa.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button data-id="{{ $item->id }}" type="button" class="text-red-600 btn-delete rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-6">No siswa found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>