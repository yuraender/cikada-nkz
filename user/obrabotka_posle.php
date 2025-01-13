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

$uf_fio = $user['lname'] . ' ' . $user['fname'] . ' ' . $user['patronym'];
$f_fio = iconv('utf-8', 'windows-1251', $uf_fio);

$uf_oblast_and_locality = 'обл. ' . $pData['oblast'] . ',    н.п. ' . $pData['locality'] . ', ';
$f_oblast_and_locality = iconv('utf-8', 'windows-1251', $uf_oblast_and_locality);

$uf_other_locals = 'ул. ' . $pData['street'] . ',    д. ' . $pData['home'] . ',    кв. ' . $pData['apartment'];
$f_other_locals = iconv('utf-8', 'windows-1251', $uf_other_locals);

$pdf->SetXY(31, 49);
$pdf->Cell(100, 5, $f_fio); 

$pdf->SetXY(77, 62);
$pdf->Cell(100, 5, $f_oblast_and_locality); 

$pdf->SetXY(22, 68);
$pdf->Cell(100, 5, $f_other_locals); 


$pdf->Output('D', 'Soglasie.pdf'); 


?>