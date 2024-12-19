<?php

require_once 'user_redirect_logic.php';
require_once 'user_pd_from_db.php'; 

require('fpdf/fpdf.php'); 

require_once('fpdi/autoload.php');

$pdf = new \setasign\Fpdi\Fpdi();

$pdf->AddPage();

//Set the source PDF file
$pdf->setSourceFile("sogl_starshe_18.pdf");

//Import the first page of the file
$tpl = $pdf->importPage(1);


//Use this page as template
// use the imported page and place it at point 20,30 with a width of 170 mm
$pdf->useTemplate($tpl, 0, 0, 210);

$pdf-> AddFont('TimesNewRomanPSMT','','times.php'); 
$pdf-> SetFont('TimesNewRomanPSMT','',12);

$text = iconv('utf-8', 'windows-1251', $user['lname']);

$pdf->SetXY(40, 32);
$pdf->Cell(100, 5, $text); 

$text = iconv('utf-8', 'windows-1251', $user['fname']);

$pdf->SetXY(80, 32);
$pdf->Cell(100, 5, $text); 

$text = iconv('utf-8', 'windows-1251', $user['patronym']);

$pdf->SetXY(120, 32);
$pdf->Cell(100, 5, $text); 




$pdf->Output('D', 'Soglasie.pdf'); 


?>