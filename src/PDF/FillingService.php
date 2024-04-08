<?php

namespace FacilePHP\PDF;

use setasign\Fpdi\Tcpdf\Fpdi;
use FacilePHP\pdf\Text;

/**
 * FillingService is responsible for populating a PDF with text.
 * It leverages the FPDI library, which extends TCPDF, to import and manipulate PDF templates.
 */
final class FillingService
{
    private readonly Fpdi $pdf;

    /**
     * Initializes a new FPDI instance and loads a PDF template.
     *
     * @param string $file The file path to the PDF template.
     * @param string $file The page to fill. Defaults to the first
     */
    public function __construct($file, $page = 1)
    {

        $this->pdf = new Fpdi();

        $this->pdf->AddPage();

        $this->pdf->setSourceFile($file);

        $tplId = $this->pdf->importPage($page);
        $this->pdf->useTemplate($tplId);
    }

    /**
     * Adds text elements to the PDF.
     *
     * @param array<Text> $texts An array of Text objects to be added to the PDF.
     *
     * @return void
     */
    public function addText($texts)
    {
        foreach ($texts as $text) {
            $this->pdf->SetFont($text->family, $text->style, $text->size);
            $this->pdf->SetXY($text->x, $text->y);
            $this->pdf->Write(0, $text->text);
        }
    }

    /**
     * Returns the content of the current PDF as a base64 encoded string.
     *
     * @return string The base64-encoded content of the PDF file.
     */
    public function getBase64(): string
    {
        $pdfContent = $this->pdf->Output('', 'S');

        return base64_encode($pdfContent);
    }
}
