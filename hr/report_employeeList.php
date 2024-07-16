<?php

include "../includes/db_settings.php";
include_once('../vendors/fpdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    $this->SetFont('Arial','B',13);
    // Move to the right (80 is half of the page width minus half of the title width)
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Employee List',0,0,'C');
    // Line break
    $this->Ln(20);
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

$display_heading = array('FirstName'=>'First Name', 'LastName'=> 'Last Name', 'EmailId'=> 'Email', 'Department'=> 'Department', 'Gender'=> 'Gender');

$result = mysqli_query($conn, "SELECT FirstName, LastName, EmailId, Department, Gender FROM employee") or die("database error:". mysqli_error($conn));
$header = mysqli_query($conn, "SHOW columns FROM employee where field in('FirstName', 'LastName', 'EmailId', 'Department', 'Gender')");

$pdf = new PDF();
//header
$pdf->AddPage();
//footer page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);

// Define column widths
$widths = array(35, 35, 60, 20, 30);

// Print header
$i = 0;
foreach($header as $heading) {
    $pdf->Cell($widths[$i],10,$display_heading[$heading['Field']],1);
    $i++;
}

// Print data
foreach($result as $row) {
    $pdf->SetFont('Arial','',10);
    $pdf->Ln();
    $i = 0;
    foreach($row as $column) {
        $pdf->Cell($widths[$i],10,$column,1);
        $i++;
    }
}

$pdf->Output();
?>
