<?php
include "../includes/db_settings.php";
include_once('../vendors/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial','B',13);
       
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$display_heading = array(
    'points'=>'Points',
    
        'code'=> 'Key'
);

$mline = "select points,code,description from scores_setup";
$result = mysqli_query($conn, $mline) or die("database error:". mysqli_error($conn));

$pdf = new PDF();
// Add a new page
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',12);

// Define column widths
$widths = array(50,  80);

// Print header
$pdf->SetFont('Arial','B',12);
foreach($display_heading as $heading) {
  //  $pdf->Cell(40, 10, $heading, 1);
}

$pdf->Ln();

// Print data
$pdf->SetFont('Arial','',10);
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Ln();
    foreach($display_heading as $key => $heading) {
        $pdf->Cell(30, 10, $row[$key], 0);
    }
}

$pdf->Output();
?>
