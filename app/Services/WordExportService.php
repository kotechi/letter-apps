<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class WordExportService
{
    public static function generateSurat($data)
    {
        $templatePath = resource_path('word_templates/surat_template.docx');

        $safeName = isset($data['nama']) ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nama']) : time();

        $outputDir = storage_path('app/public');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputDocx = $outputDir . DIRECTORY_SEPARATOR . 'surat-' . $safeName . '.docx';
        $outputPdf  = $outputDir . DIRECTORY_SEPARATOR . 'surat-' . $safeName . '.pdf';

        $template = new TemplateProcessor($templatePath);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            } elseif (is_object($value)) {
                $value = method_exists($value, '__toString') ? (string) $value : json_encode($value);
            } elseif ($value === null) {
                $value = '';
            }
            $template->setValue((string) $key, (string) $value);
        }

        $template->saveAs($outputDocx);


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