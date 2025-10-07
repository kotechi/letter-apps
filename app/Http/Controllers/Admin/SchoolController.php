<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();
        return view('admin.school.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:1000',
            'provinsi' => 'nullable|string|max:50',
            'kota' => 'nullable|max:255',
        ]);

        School::create($data);

        return redirect()->route('admin.school')->with('success', 'School created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $school = School::findOrFail($id);
        return view('admin.school.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $school = School::findOrFail($id);
       return view('admin.school.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:50',
            'kota' => 'nullable|max:255',
        ]);

       $school->update($data);

       return redirect()->route('admin.school')->with('success', 'School updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      //
      $school = School::findOrFail($id);
      $school->delete();
       return redirect()->route('admin.school')->with('success', 'School deleted.');
    }
}