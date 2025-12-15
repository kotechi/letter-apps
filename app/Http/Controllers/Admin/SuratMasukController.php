<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SuratMasuk;
use App\Models\Admin\Lampiran;
use App\Models\Admin\DaftarSiswaLampiran;
use App\Services\SuratMasukExportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::with('lampiran_list')->orderByDesc('tanggal_masehi')->paginate(10);
        return view('admin.surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        return view('admin.surat-masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masehi' => 'required|date',
            'tanggal_hijriah' => 'required|string',
            'nomor_surat' => 'required|string',
            'nama_kepala_bidang' => 'nullable|string',
            'nip_kepala_bidang' => 'nullable|string',
            'yth_nama_sekolah_tujuan' => 'nullable|string',
            'yth_alamat_sekolah_tujuan' => 'nullable|string',
            'nama_sekolah_tujuan' => 'nullable|string',
            
            'lampiran.*.nomor_lampiran' => 'required|string',
            'lampiran.*.tanggal_lampiran' => 'required|date',
            'lampiran.*.nama_kabid_lampiran' => 'nullable|string',
            'lampiran.*.nip_kabid_lampiran' => 'nullable|string',
            
            'lampiran.*.siswa.*.nama_siswa' => 'required|string',
            'lampiran.*.siswa.*.ttl_siswa' => 'required|string',
            'lampiran.*.siswa.*.nisn' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Create Surat Masuk
            $suratMasuk = SuratMasuk::create([
                'tanggal_masehi' => $request->tanggal_masehi,
                'tanggal_hijriah' => $request->tanggal_hijriah,
                'nomor_surat' => $request->nomor_surat,
                'lampiran' => $request->lampiran_text ?? null,
                'nomor_surat_saudara' => $request->nomor_surat_saudara ?? null,
                'tanggal_permohonan' => $request->tanggal_permohonan ?? null,
                'nama_kepala_bidang' => $request->nama_kepala_bidang ?? null,
                'nip_kepala_bidang' => $request->nip_kepala_bidang ?? null,
                'yth_nama_sekolah_tujuan' => $request->yth_nama_sekolah_tujuan ?? null,
                'yth_alamat_sekolah_tujuan' => $request->yth_alamat_sekolah_tujuan ?? null,
                'nama_sekolah_tujuan' => $request->nama_sekolah_tujuan ?? null,
            ]);

            // Create Lampiran and Siswa
            if ($request->has('lampiran')) {
                foreach ($request->lampiran as $lampiranData) {
                    $lampiran = Lampiran::create([
                        'nomor_lampiran' => $lampiranData['nomor_lampiran'],
                        'tanggal_lampiran' => $lampiranData['tanggal_lampiran'],
                        'nama_kabid_lampiran' => $lampiranData['nama_kabid_lampiran'] ?? null,
                        'nip_kabid_lampiran' => $lampiranData['nip_kabid_lampiran'] ?? null,
                        'surat_masuk_id' => $suratMasuk->id,
                    ]);

                    if (isset($lampiranData['siswa'])) {
                        foreach ($lampiranData['siswa'] as $index => $siswaData) {
                            DaftarSiswaLampiran::create([
                                'no' => $index + 1,
                                'nama_siswa' => $siswaData['nama_siswa'],
                                'ttl_siswa' => $siswaData['ttl_siswa'],
                                'kelas_masuk' => $siswaData['kelas_masuk'] ?? null,
                                'tahun_masuk' => $siswaData['tahun_masuk'] ?? null,
                                'asal_sekolah' => $siswaData['asal_sekolah'] ?? null,
                                'nisn' => $siswaData['nisn'] ?? null,
                                'lampiran_id' => $lampiran->id,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('lampiran_list.daftarSiswa');
        return view('admin.surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('lampiran_list.daftarSiswa');
        return view('admin.surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'tanggal_masehi' => 'required|date',
            'tanggal_hijriah' => 'required|string',
            'nomor_surat' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $suratMasuk->update([
                'tanggal_masehi' => $request->tanggal_masehi,
                'tanggal_hijriah' => $request->tanggal_hijriah,
                'nomor_surat' => $request->nomor_surat,
                'lampiran' => $request->lampiran_text ?? null,
                'nomor_surat_saudara' => $request->nomor_surat_saudara ?? null,
                'tanggal_permohonan' => $request->tanggal_permohonan ?? null,
                'nama_kepala_bidang' => $request->nama_kepala_bidang ?? null,
                'yth_nama_sekolah_tujuan' => $request->yth_nama_sekolah_tujuan ?? null,
                'yth_alamat_sekolah_tujuan' => $request->yth_alamat_sekolah_tujuan ?? null,
                'nama_sekolah_tujuan' => $request->nama_sekolah_tujuan ?? null,
                'nip_kepala_bidang' => $request->nip_kepala_bidang ?? null,
            ]);

            // Delete existing lampiran and siswa
            foreach ($suratMasuk->lampiran_list as $lamp) {
                $lamp->daftarSiswa()->delete();
                $lamp->delete();
            }

            // Create new lampiran and siswa
            if ($request->has('lampiran')) {
                foreach ($request->lampiran as $lampiranData) {
                    $lampiran = Lampiran::create([
                        'nomor_lampiran' => $lampiranData['nomor_lampiran'],
                        'tanggal_lampiran' => $lampiranData['tanggal_lampiran'],
                        'nama_kabid_lampiran' => $lampiranData['nama_kabid_lampiran'] ?? null,
                        'nip_kabid_lampiran' => $lampiranData['nip_kabid_lampiran'] ?? null,
                        'surat_masuk_id' => $suratMasuk->id,
                    ]);

                    if (isset($lampiranData['siswa'])) {
                        foreach ($lampiranData['siswa'] as $index => $siswaData) {
                            DaftarSiswaLampiran::create([
                                'no' => $index + 1,
                                'nama_siswa' => $siswaData['nama_siswa'],
                                'ttl_siswa' => $siswaData['ttl_siswa'],
                                'kelas_masuk' => $siswaData['kelas_masuk'] ?? null,
                                'tahun_masuk' => $siswaData['tahun_masuk'] ?? null,
                                'asal_sekolah' => $siswaData['asal_sekolah'] ?? null,
                                'nisn' => $siswaData['nisn'] ?? null,
                                'lampiran_id' => $lampiran->id,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        DB::beginTransaction();
        try {
            foreach ($suratMasuk->lampiran_list as $lampiran) {
                $lampiran->daftarSiswa()->delete();
                $lampiran->delete();
            }
            $suratMasuk->delete();
            
            DB::commit();
            return redirect()->route('admin.surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function exportWord(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('lampiran_list.daftarSiswa');

        $data = [
            'tanggal_masehi' => $suratMasuk->tanggal_masehi->locale('id')->translatedFormat('d F Y'),
            'tanggal_hijriah' => $suratMasuk->tanggal_hijriah,
            'nomor_surat' => $suratMasuk->nomor_surat,
            'lampiran' => $suratMasuk->lampiran ?? '-',
            'nomor_surat_saudara' => $suratMasuk->nomor_surat_saudara ?? '-',
            'tanggal_permohonan' => $suratMasuk->tanggal_permohonan ? $suratMasuk->tanggal_permohonan->locale('id')->translatedFormat('d F Y') : '-',
            'nama_kepala_bidang' => $suratMasuk->nama_kepala_bidang ?? '-',
            'nip_kepala_bidang' => $suratMasuk->nip_kepala_bidang ?? '-',
            'yth_nama_sekolah_tujuan' => $suratMasuk->yth_nama_sekolah_tujuan ?? '-',
            'yth_alamat_sekolah_tujuan' => $suratMasuk->yth_alamat_sekolah_tujuan ?? '-',
            'nama_sekolah_tujuan' => $suratMasuk->nama_sekolah_tujuan ?? '-',
        ];

        // Prepare lampiran data
        $lampiranData = [];
        foreach ($suratMasuk->lampiran_list as $lampiran) {
            $siswaData = [];
            foreach ($lampiran->daftarSiswa as $siswa) {
                $siswaData[] = [
                    'no' => $siswa->no,
                    'nama_siswa' => $siswa->nama_siswa,
                    'ttl_siswa' => $siswa->ttl_siswa,
                    'kelas_masuk' => $siswa->kelas_masuk ?? '-',
                    'tahun_masuk' => $siswa->tahun_masuk ?? '-',
                    'asal_sekolah' => $siswa->asal_sekolah ?? '-',
                    'nisn' => $siswa->nisn ?? '-',
                ];
            }

            $lampiranData[] = [
                'nomor_lampiran' => $lampiran->nomor_lampiran,
                'tanggal_lampiran' => $lampiran->tanggal_lampiran->locale('id')->translatedFormat('d F Y'),
                'nama_kabid_lampiran' => $lampiran->nama_kabid_lampiran ?? '-',
                'nip_kabid_lampiran' => $lampiran->nip_kabid_lampiran ?? '-',
                'siswa' => $siswaData,
            ];
        }

        $data['lampiran_data'] = $lampiranData;

        $files = SuratMasukExportService::generateSuratMasuk($data);

        // Save to database
        $docxStoragePath = null;
        $pdfStoragePath = null;

        if (isset($files['docx']) && file_exists($files['docx'])) {
            $docxFileName = 'surat_masuk/' . time() . '_' . $suratMasuk->nomor_surat . '.docx';
            Storage::disk('public')->put($docxFileName, file_get_contents($files['docx']));
            $docxStoragePath = $docxFileName;
        }

        if (isset($files['pdf']) && file_exists($files['pdf'])) {
            $pdfFileName = 'surat_masuk/' . time() . '_' . $suratMasuk->nomor_surat . '.pdf';
            Storage::disk('public')->put($pdfFileName, file_get_contents($files['pdf']));
            $pdfStoragePath = $pdfFileName;
        }

        // Update surat masuk with file paths
        $suratMasuk->update([
            'file_docx' => $docxStoragePath,
            'file_pdf' => $pdfStoragePath,
        ]);

        $downloadPath = $files['pdf'] ?? $files['docx'];

        if (!file_exists($downloadPath)) {
            return redirect()->back()->with('error', 'File tidak berhasil dibuat.');
        }

        return response()->download($downloadPath);
    }

    public function download(SuratMasuk $suratMasuk, $type)
    {
        if ($type === 'pdf' && $suratMasuk->file_pdf) {
            $filePath = storage_path('app/public/' . $suratMasuk->file_pdf);
            $fileName = basename($suratMasuk->file_pdf);
        } elseif ($type === 'docx' && $suratMasuk->file_docx) {
            $filePath = storage_path('app/public/' . $suratMasuk->file_docx);
            $fileName = basename($suratMasuk->file_docx);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return response()->download($filePath, $fileName);
    }
}
