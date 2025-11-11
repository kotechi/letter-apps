<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\WordExportService;
use App\Models\Admin\Siswa;
use App\Models\Admin\School;
use App\Models\Admin\Surat;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{

    public function index(Request $request)
    {
        
        $query = Surat::query();
        $schools = School::all();
        $siswa = Siswa::all();

        // filter tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_selesai);
        }

        // search by nama atau no surat
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                ->orWhere('no_surat_keterangan', 'like', '%'.$request->search.'%')
                ->orWhere('no_surat_asal', 'like', '%'.$request->search.'%');
            });
        }

        $surats = $query->orderByDesc('tanggal_surat')->paginate(10);

        return view('admin.surat.index', compact('surats', 'schools', 'siswa'));
    }


    public function show(Surat $surat)
    {
        $surat = Surat::findOrFail($surat->id);
        return view('admin.surat.detail', compact('surat'));
    }

    public function destroy(Surat $surat)
    {
        // Delete associated files
        if ($surat->file_docx && Storage::disk('public')->exists($surat->file_docx)) {
            Storage::disk('public')->delete($surat->file_docx);
        }
        if ($surat->file_pdf && Storage::disk('public')->exists($surat->file_pdf)) {
            Storage::disk('public')->delete($surat->file_pdf);
        }

        $surat->delete();
        return redirect()->route('admin.surats')->with('success', 'Surat deleted successfully.');
    }

    public function edit(Surat $surat)
    {
        $siswa = Siswa::all();
        $schools = School::all();
        return view('admin.surat.edit', compact('surat', 'siswa', 'schools'));
    }
    public function update(Request $request, Surat $surat)
    {
        $surat = Surat::findOrFail($surat->id);
        $data = $request->all();
        $surat->update($data);

        return redirect()->route('admin.surats')->with('success', 'Surat updated successfully.');
    }


    public function download(Surat $surat, $type)
    {
        if ($type === 'pdf' && $surat->file_pdf) {
            $filePath = storage_path('app/public/' . $surat->file_pdf);
            $fileName = basename($surat->file_pdf);
        } elseif ($type === 'docx' && $surat->file_docx) {
            $filePath = storage_path('app/public/' . $surat->file_docx);
            $fileName = basename($surat->file_docx);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        return response()->download($filePath, $fileName);
    }

    //// Export and Save Surat untuk halaman dashboard
    public function export(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $siswa = Siswa::findOrFail($siswa_id);

        $asal_id = $siswa->asal_sekolah_id ?? $siswa->asal_sekolah ?? null;
        $sekolah_asal = $asal_id ? School::find($asal_id) : null;

        $sekolah_id = $request->sekolah_id;
        $sekolah = $sekolah_id ? School::find($sekolah_id) : null;

        $waktu_sekarang = now()->locale('id')->translatedFormat('d F Y');

        $data = [
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas,
            'alamat' => optional($sekolah)->alamat ?? '',
            'tempat_lahir' => $siswa->tempat_lahir,
            'tanggal_lahir' => $siswa->tanggal_lahir ? (string) $siswa->tanggal_lahir : '',
            'nisn' => $siswa->nisn,
            'nis' => $siswa->nis,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'asal_sekolah' => optional($sekolah_asal)->nama_sekolah ?? '',
            'alamat_sekolah' => optional($sekolah_asal)->alamat ?? '',

            'nama_sekolah_tujuan' => $sekolah->nama_sekolah,
            'alamat_sekolah_tujuan' => $sekolah->alamat,
            'kota_sekolah_tujuan' => $sekolah->kota,
            'provinsi_sekolah_tujuan' => $sekolah->provinsi,
            'waktu_sekarang' => $waktu_sekarang,
            'no_surat_asal' => $request->no_surat_asal ? $request->no_surat_asal : '-',
            'no_surat_keterangan' => $request->no_surat_keterangan ? $request->no_surat_keterangan : '-',
            'nip_kepsek' => $request->nip_kepsek ? $request->nip_kepsek : '-',
            'nama_kepsek' => $request->nama_kepsek ? $request->nama_kepsek : '-',
        ];

        $files = WordExportService::generateSurat($data);

        // prefer pdf if available, else fallback to docx
        $downloadPath = $files['pdf'] ?? $files['docx'];

        if (!file_exists($downloadPath)) {
            abort(500, 'File not generated. Check server conversion and permissions.');
        }
        $docxStoragePath = null;
        $pdfStoragePath = null;

        if (isset($files['docx']) && file_exists($files['docx'])) {
            $docxFileName = 'surats/' . time() . '_' . $siswa->nama . '.docx';
            Storage::disk('public')->put($docxFileName, file_get_contents($files['docx']));
            $docxStoragePath = $docxFileName;
        }

        if (isset($files['pdf']) && file_exists($files['pdf'])) {
            $pdfFileName = 'surats/' . time() . '_' . $siswa->nama . '.pdf';
            Storage::disk('public')->put($pdfFileName, file_get_contents($files['pdf']));
            $pdfStoragePath = $pdfFileName;
        }

        // Save to database
        $surat = Surat::create([
            'siswa_id' => $siswa->id,
            'sekolah_id' => $sekolah->id,
            'asal_sekolah_id' => $asal_id,
            
            // Snapshot data siswa
            'nama' => $siswa->nama,
            'kelas' => $siswa->kelas,
            'nisn' => $siswa->nisn,
            'nis' => $siswa->nis,
            'tempat_lahir' => $siswa->tempat_lahir,
            'tanggal_lahir' => $siswa->tanggal_lahir,
            'jenis_kelamin' => $siswa->jenis_kelamin,
            
            // Snapshot data sekolah tujuan
            'nama_sekolah_tujuan' => $sekolah->nama_sekolah,
            'alamat_sekolah_tujuan' => $sekolah->alamat,
            'kota_sekolah_tujuan' => $sekolah->kota,
            'provinsi_sekolah_tujuan' => $sekolah->provinsi,
            
            // Snapshot data sekolah asal
            'asal_sekolah' => optional($sekolah_asal)->nama_sekolah,
            'alamat_sekolah_asal' => optional($sekolah_asal)->alamat,
            
            // Data surat
            'no_surat_asal' => $request->no_surat_asal ?: null,
            'no_surat_keterangan' => $request->no_surat_keterangan ?: null,
            'nip_kepsek' => $request->nip_kepsek ?: null,
            'nama_kepsek' => $request->nama_kepsek ?: null,
            'tanggal_surat' => now(),
            
            // File paths
            'file_docx' => $docxStoragePath,
            'file_pdf' => $pdfStoragePath,
            
        ]);


        return response()->download($downloadPath);
    }

    public function destroyall(Request $request)
    {
        // Get all surats
        $surats = Surat::all();
        
        // Delete each surat's files
        foreach ($surats as $surat) {
            // Delete DOCX file if exists
            if ($surat->file_docx && Storage::disk('public')->exists($surat->file_docx)) {
                Storage::disk('public')->delete($surat->file_docx);
            }
            
            // Delete PDF file if exists
            if ($surat->file_pdf && Storage::disk('public')->exists($surat->file_pdf)) {
                Storage::disk('public')->delete($surat->file_pdf);
            }
        }
        
        // Delete all surat records from database
        Surat::query()->delete();
        
        return redirect()->route('admin.surats')->with('success', 'Semua surat berhasil dihapus.');
    }
};