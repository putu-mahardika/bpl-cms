<?php
require('vendor/fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('img/logoo.png',10,16,50);
    // Arial bold 12
    $this->SetFont('Arial','B',12);
    // Geser Ke Kanan 35mm
    $this->Cell(53);
    // Judul
    $this->Cell(48,7,'PT BERKAH PERMATA LOGISTIK',0,1,'L');
    $this->Cell(53);
    $this->SetFont('Arial','',10);
    $this->Cell(48,5,'Gedung The Vida Lt.17',0,1,'L');
    $this->Cell(53);
    $this->Cell(48,5,'Jl. Pejuangan No. 817 Kebon Jeruk, Jakarta Barat, DKI Jakarta - 11530',0,1,'L');
    $this->Cell(53);
    $this->Cell(48,5,'Telp : (021) 2977-8141 | Email : adm1.berkahpermatalogistik@gmail.com',0,1,'L');
    $this->Cell(53);
    $this->Cell(48,5,'www.berkahpermatalogistik.com',0,1,'L');
    $this->SetFont('Arial','B',12);
    // Garis Bawah Double
    $this->Cell(190,1,'','B',1,'L');
    $this->Cell(190,1,'','B',0,'L');
    // Line break 5mm
    $this->Ln(5);
}
// Page footer
function Footer()
{
    // Posisi 15 cm dari bawah
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Membuat file PDF
$pdf = new PDF();
//Alias total halaman dengan default {nb} (berhubungan dengan PageNo())
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//Mencetak kalimat dengan perulangan
for($i=1;$i<=45;$i++)
    $pdf->Cell(0,10,'Baris '.$i,0,1);
    //Menutup dokumen dan dikirim ke browser
$pdf->Output();
?>