<?php

require_once 'user_redirect_logic.php';
require_once 'user_pd_from_db.php'; 

require('fpdf/fpdf.php'); 

require_once('fpdi/autoload.php');

$pdf = new \setasign\Fpdi\Fpdi();

$pdf->AddPage();

//Set the source PDF file
$pdf->setSourceFile("sogl_do_18.pdf");

//Import the first page of the file
$tpl = $pdf->importPage(1);


//Use this page as template
// use the imported page and place it at point 20,30 with a width of 170 mm
$pdf->useTemplate($tpl, 0, 0, 210);

$pdf-> AddFont('TimesNewRomanPSMT','','times.php'); 
$pdf-> SetFont('TimesNewRomanPSMT','',12);

$text = iconv('utf-8', 'windows-1251', $pData['nameParent']);

$pdf->SetXY(40, 30);
$pdf->Cell(100, 5, $text); 




$pdf->Output('D', 'Soglasie.pdf'); 


?>