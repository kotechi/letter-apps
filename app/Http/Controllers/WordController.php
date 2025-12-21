<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WordExportService;
use App\Models\Admin\Siswa;
use App\Models\Admin\School;

class WordController extends Controller
{
    public function export(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $siswa = Siswa::findOrFail($siswa_id);

        // try both possible column names
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
            'tanggal_lahir' => $siswa->tanggal_lahir->locale('id')->translatedFormat('d F Y') ?? '',
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

        return response()->download($downloadPath);
    }
}