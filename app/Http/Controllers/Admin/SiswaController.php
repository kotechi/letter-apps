<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Siswa;
use App\Models\Admin\School;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // kirim semua data agar DataTables client-side bekerja
        $siswa = Siswa::orderBy('id', 'desc')->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        return view('admin.siswa.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => ['required', Rule::in(['laki-laki','perempuan','L','P','male','female'])],
            'asal_sekolah' => 'required',
            'nisn' => 'required|string|max:50|unique:siswas,nisn',
            'nis' => 'nullable|string|max:50|unique:siswas,nis',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        Siswa::create($data);

        return redirect()->route('admin.siswa')->with('success', 'Siswa dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $schools = School::all();
        return view('admin.siswa.edit', compact('siswa', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jenis_kelamin' => ['required', Rule::in(['laki-laki','perempuan','L','P','male','female'])],
            'asal_sekolah' => 'required',
            'nisn' => ['required','string','max:50', Rule::unique('siswas','nisn')->ignore($siswa->id)],
            'nis' => ['nullable','string','max:50', Rule::unique('siswas','nis')->ignore($siswa->id)],
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ]);

        $siswa->update($data);

        return redirect()->route('admin.siswa')->with('success', 'Siswa diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa')->with('success', 'Siswa dihapus.');
    }
}