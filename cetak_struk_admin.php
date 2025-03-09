<?php
require_once 'config.php';
require_once 'function.php';
require('halaman/fpdf/fpdf.php');

$id_user = isset($_GET['id_user']) ? intval($_GET['id_user']) : null;
if (!$id_user) {
    exit('ID user tidak valid.');
}

$query = "SELECT u.username, m.nama AS nama_menu, p.jumlah, p.total_harga, p.status, p.created_at 
          FROM pesanan p
          JOIN user u ON p.id_user = u.id_user
          JOIN menu m ON p.id_menu = m.id_menu
          WHERE u.id_user = ?
          ORDER BY p.created_at DESC";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_all(MYSQLI_ASSOC);

$totalKeseluruhan = 0;
foreach ($pesanan as $p) {
    $totalKeseluruhan += $p['total_harga'];
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(30, 10, 'Struk Pesanan Toko Buku FTTI', 0, 0, 'C');
        $this->Ln(20);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(0, 10, 'Nama Pemesan: ' . ($pesanan[0]['username'] ?? 'Tidak Ditemukan'), 0, 1);
$pdf->Ln(5);

$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama Menu', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jumlah', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total Harga', 1, 0, 'C');
$pdf->Cell(30, 10, 'Status', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tanggal', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
foreach ($pesanan as $index => $p) {
    $startY = $pdf->GetY();
    $pdf->Cell(10, 10, $index + 1, 1, 0, 'C');
    $pdf->MultiCell(50, 5, $p['nama_menu'], 1, 'L');
    $cellHeight = $pdf->GetY() - $startY;
    $pdf->SetXY($pdf->GetX() + 60, $startY);
    $pdf->Cell(30, $cellHeight, $p['jumlah'], 1, 0, 'C');
    $pdf->Cell(40, $cellHeight, 'Rp ' . number_format($p['total_harga'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, $cellHeight, $p['status'], 1, 0, 'C');
    $pdf->Cell(30, $cellHeight, date('d/m/Y H:i', strtotime($p['created_at'])), 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(150, 10, 'Total Keseluruhan:', 0, 0, 'R');
$pdf->Cell(40, 10, 'Rp ' . number_format($totalKeseluruhan, 0, ',', '.'), 0, 1, 'R');

$pdf->Output();