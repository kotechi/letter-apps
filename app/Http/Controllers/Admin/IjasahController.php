<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Ijasah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IjasahController extends Controller
{
    public function index()
    {
        $ijasahs = Ijasah::all();
        return view('admin.ijasah.index', compact('ijasahs'));
    }
    public function create()
    {
        return view('admin.ijasah.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        Ijasah::create($request->all());

        return redirect()->route('admin.ijasah.index')->with('success', 'Ijasah created successfully.');
    }
    public function edit($id)
    {
        $ijasah = Ijasah::findOrFail($id);
        return view('admin.ijasah.edit', compact('ijasah'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);
        $ijasah = Ijasah::findOrFail($id);
        $ijasah->update($request->all());
        return redirect()->route('admin.ijasah.index')->with('success', 'Ijasah updated successfully.');
    }
    public function destroy($id)
    {
        $ijasah = Ijasah::findOrFail($id);
        $ijasah->delete();
        return redirect()->route('admin.ijasah.index')->with('success', 'Ijasah deleted successfully.');
    }
    public function show($id)
    {
        $ijasah = Ijasah::findOrFail($id);
        return view('admin.ijasah.detail', compact('ijasah'));
    }
}
