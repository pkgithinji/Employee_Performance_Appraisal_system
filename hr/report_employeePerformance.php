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
    $this->Ln(7);
    $this->Cell(80);
    $this->Cell(30,10,'Performance Appraisal List',0,0,'C');
    // Line break
    $this->Ln(10);
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

//$display_heading = array('FirstName'=>'First Name', 'LastName'=> 'Last Name', 'EmailId'=> 'Email', 'Department'=> 'Department', 'Gender'=> 'Gender');
$display_heading = array(
    'EmployeeName'=>'Employee Name',
    'Department'=> 'Department',
    'avg_agreed_score'=> 'Average Score',
    'recomm'=> 'Recommendation'
);

$mline = "
    SELECT t.EmployeeName, t.Department, ROUND(AVG(er.agreed_score), 2) AS avg_agreed_score, recommendation_engine(AVG(er.agreed_score)) AS recomm
    FROM (
        SELECT e.emp_id, CONCAT(e.FirstName, ' ', e.LastName) AS EmployeeName, e.supervisor_id, e.Department, u.user_id
        FROM employee e
        LEFT JOIN users u ON e.emp_id = u.emp_id
    ) t
    INNER JOIN employee_rating er ON t.user_id = er.evaluatee_id
    JOIN evaluation_periods p ON p.code = er.evaluation_period
    WHERE p.status = 1
    GROUP BY t.emp_id, t.EmployeeName, t.Department";
$result = mysqli_query($conn, $mline) or die("database error:". mysqli_error($conn));
$header = mysqli_query($conn, "SHOW columns FROM employee where field in('FirstName', 'LastName', 'EmailId', 'Department', 'Gender')");

$pdf = new PDF();
//header
$pdf->AddPage();
//footer page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);

// Define column widths
$widths = array(40, 40, 40, 100);

// Print header
$i = 0;
//foreach($header as $heading) {
   // $pdf->Cell($widths[$i],10,$display_heading[$heading['Field']],1);
   // $i++;
//}
$pdf->SetFont('Arial','B',12);
foreach($display_heading as $heading) {
 $pdf->Cell(40, 10, $heading, 0);
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
