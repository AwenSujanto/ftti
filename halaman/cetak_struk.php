<?php
require_once '../config.php';
require_once '../function.php';
require('fpdf/fpdf.php');

if (!isset($_SESSION["akun-user"]['id_user'])) {
    exit('Akses ditolak');
}

$user_id = $_SESSION["akun-user"]['id_user'];

$query = "SELECT p.id_pesanan, m.nama, p.jumlah, p.total_harga, p.status, p.created_at 
          FROM pesanan p 
          JOIN menu m ON p.id_menu = m.id_menu 
          WHERE p.id_user = ?
          ORDER BY p.created_at DESC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell(30,10,'Struk Pesanan Toko Buku FTTI',0,0,'C');
        $this->Ln(20);
    }
}
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);


// Tambahkan nama pemesan
$pdf->Cell(0,10,'Nama Pemesan: '.$_SESSION["akun-user"]['username'],0,1);
$pdf->Ln(5);

$pdf->Cell(10,10,'No',1,0,'C');
$pdf->Cell(50,10,'Nama Menu',1,0,'C');
$pdf->Cell(30,10,'Jumlah',1,0,'C');
$pdf->Cell(40,10,'Total Harga',1,0,'C');
$pdf->Cell(30,10,'Status',1,0,'C');
$pdf->Cell(30,10,'Tanggal',1,1,'C');

$pdf->SetFont('Arial','',10);
foreach($pesanan as $index => $p) {
    $startY = $pdf->GetY();
    $pdf->Cell(10,10,$index+1,1,0,'C');
    
    $pdf->MultiCell(50,5,$p['nama'],1,'L');
    $cellHeight = $pdf->GetY() - $startY;
    
    $pdf->SetXY($pdf->GetX() + 60, $startY);
    $pdf->Cell(30,$cellHeight,$p['jumlah'],1,0,'C');
    $pdf->Cell(40,$cellHeight,'Rp '.number_format($p['total_harga'],0,',','.'),1,0,'R');
    $pdf->Cell(30,$cellHeight,$p['status'],1,0,'C');
    $pdf->Cell(30,$cellHeight,date('d/m/Y', strtotime($p['created_at'])),1,1,'C');
    
    $pdf->SetY($pdf->GetY());
}

$pdf->Output();