
<x-layouts.app title="School">
    <div class="w-full ml-2 bg-white rounded-sm shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Schools</h2>
            <a href="{{ route('admin.school.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Create School
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table id="my-table" class="custom-table min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th data-sortable="true">id</th>
                        <th data-sortable="true">Nama Sekolah</th>
                        <th data-sortable="true">Alamat</th>
                        <th data-sortable="true">Provinsi</th>
                        <th data-sortable="true">Kota</th>
                        <th data-sortable="true">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($schools->count() > 0)
                        @foreach ($schools as $index => $school)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $school->nama_sekolah }}</td>
                                <td>{{ $school->alamat }}</td> {{-- typo sebelumnya: “alamay” --}}
                                <td>{{ $school->kota ?? '-' }}</td>
                                <td>{{ $school->provinsi ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.school.edit', $school) }}"
                                    class="text-blue-600 mr-2 rounded-md px-3 py-1 border border-blue-500 hover:bg-blue-600 hover:text-white transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.school.destroy', $school) }}" method="POST" class="inline" id="delete-form-{{ $school->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-id="{{ $school->id }}"
                                                class="text-red-600 btn-delete rounded-md px-3 py-1 border border-red-500 hover:bg-red-600 hover:text-white transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="empty-state">
                            <td colspan="5" class="text-center text-gray-500 py-6">No schools found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>