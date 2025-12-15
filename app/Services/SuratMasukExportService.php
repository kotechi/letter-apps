<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Process;

class SuratMasukExportService
{
    public static function generateSuratMasuk($data)
    {
        $templatePath = resource_path('word_templates/surat_masuk_template.docx');

        $safeName = isset($data['nomor_surat']) ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nomor_surat']) : time();

        $outputDir = storage_path('app/public/surat_masuk');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputDocx = $outputDir . DIRECTORY_SEPARATOR . 'surat-masuk-' . $safeName . '.docx';
        $outputPdf  = $outputDir . DIRECTORY_SEPARATOR . 'surat-masuk-' . $safeName . '.pdf';

        $template = new TemplateProcessor($templatePath);

        // Set nilai utama
        $template->setValue('tanggal_masehi', $data['tanggal_masehi'] ?? '-');
        $template->setValue('tanggal_hijriah', $data['tanggal_hijriah'] ?? '-');
        $template->setValue('nomor_surat', $data['nomor_surat'] ?? '-');
        $template->setValue('lampiran', $data['lampiran'] ?? '-');
        $template->setValue('nomor_surat_saudara', $data['nomor_surat_saudara'] ?? '-');
        $template->setValue('tanggal_permohonan', $data['tanggal_permohonan'] ?? '-');
        $template->setValue('nama_kepala_bidang', $data['nama_kepala_bidang'] ?? '-');
        $template->setValue('nip_kepala_bidang', $data['nip_kepala_bidang'] ?? '-');
        
        // Field Yth (Yang Terhormat)
        $template->setValue('yth_nama_sekolah_tujuan', $data['yth_nama_sekolah_tujuan'] ?? '-');
        $template->setValue('yth_alamat_sekolah_tujuan', $data['yth_alamat_sekolah_tujuan'] ?? '-');
        $template->setValue('nama_sekolah_tujuan', $data['nama_sekolah_tujuan'] ?? '-');

        // Ambil lampiran dan siswa
        if (isset($data['lampiran_data'][0])) {
            $lampiran = $data['lampiran_data'][0];
            
            $template->setValue('nomor_lampiran', $lampiran['nomor_lampiran'] ?? '-');
            $template->setValue('tanggal_lampiran', $lampiran['tanggal_lampiran'] ?? '-');
            $template->setValue('nama_kabid_lampiran', $lampiran['nama_kabid_lampiran'] ?? '-');
            $template->setValue('nip_kabid_lampiran', $lampiran['nip_kabid_lampiran'] ?? '-');
            
            // Clone row untuk semua siswa
            if (isset($lampiran['siswa']) && is_array($lampiran['siswa']) && count($lampiran['siswa']) > 0) {
                // Clone row sebanyak jumlah siswa
                $template->cloneRow('no_siswa', count($lampiran['siswa']));
                
                // Loop untuk mengisi data setiap siswa
                foreach ($lampiran['siswa'] as $index => $siswa) {
                    $rowNum = $index + 1; // Row dimulai dari 1
                    
                    $template->setValue('no_siswa#' . $rowNum, $siswa['no'] ?? ($index + 1));
                    $template->setValue('nama_siswa#' . $rowNum, $siswa['nama_siswa'] ?? '-');
                    $template->setValue('ttl_siswa#' . $rowNum, $siswa['ttl_siswa'] ?? '-');
                    $template->setValue('kelas_masuk#' . $rowNum, $siswa['kelas_masuk'] ?? '-');
                    $template->setValue('tahun_masuk#' . $rowNum, $siswa['tahun_masuk'] ?? '-');
                    $template->setValue('asal_sekolah#' . $rowNum, $siswa['asal_sekolah'] ?? '-');
                    $template->setValue('nisn#' . $rowNum, $siswa['nisn'] ?? '-');
                }
            } else {
                // Jika tidak ada siswa, set nilai default
                $template->setValue('no_siswa', '-');
                $template->setValue('nama_siswa', '-');
                $template->setValue('ttl_siswa', '-');
                $template->setValue('kelas_masuk', '-');
                $template->setValue('tahun_masuk', '-');
                $template->setValue('asal_sekolah', '-');
                $template->setValue('nisn', '-');
            }
        }

        $template->saveAs($outputDocx);

        // Convert to PDF
        try {
            $process = new Process([
                'soffice',
                '--headless',
                '--convert-to',
                'pdf',
                '--outdir',
                dirname($outputPdf),
                $outputDocx
            ]);
            $process->setTimeout(60);
            $process->run();

            if (!$process->isSuccessful()) {
                $outputPdf = null;
            } else {
                if (!file_exists($outputPdf)) {
                    $possible = dirname($outputPdf) . DIRECTORY_SEPARATOR . pathinfo($outputDocx, PATHINFO_FILENAME) . '.pdf';
                    $outputPdf = file_exists($possible) ? $possible : null;
                }
            }
        } catch (\Throwable $e) {
            $outputPdf = null;
        }

        return [
            'docx' => $outputDocx,
            'pdf'  => $outputPdf
        ];
    }
}