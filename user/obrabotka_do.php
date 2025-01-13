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

// $text = iconv('utf-8', 'windows-1251', $pData['nameParent']);
// $test_text = iconv('utf-8', 'windows-1251', 'test');

// $address = $pData['oblast'] . ' ' . $pData['locality'];
// $address_utf = iconv('utf-8', 'windows-1251', $address);

// //$pdf->SetXY(40, 30);
// $pdf->SetXY(90, 147);
// $pdf->Cell(100, 5, $test_text); 

// $pdf->SetXY(220, 184);
// $pdf->Cell(100, 5, $address_utf);

$f_roditel = iconv('utf-8', 'windows-1251', $pData['nameParent']);

$uf_oblast_and_locality = 'обл. ' . $pData['oblast'] . ',    н.п. ' . $pData['locality'] . ', ';
$f_oblast_and_locality = iconv('utf-8', 'windows-1251', $uf_oblast_and_locality);

$uf_other_locals = 'ул. ' . $pData['street'] . ',    д. ' . $pData['home'] . ',    кв. ' . $pData['apartment'];
$f_other_locals = iconv('utf-8', 'windows-1251', $uf_other_locals);

$uf_fi = $user['lname'] . ' ' . $user['fname'];
$f_fi = iconv('utf-8', 'windows-1251', $uf_fi);

$uf_ot = $user['patronym'];
$f_ot = iconv('utf-8', 'windows-1251', $uf_ot);

$pdf->SetXY(31, 44);
$pdf->Cell(100, 5, $f_roditel); 

$pdf->SetXY(77, 57);
$pdf->Cell(100, 5, $f_oblast_and_locality); 

$pdf->SetXY(22, 63);
$pdf->Cell(100, 5, $f_other_locals); 

$pdf->SetXY(120, 88);
$pdf->Cell(100, 5, $f_fi); 

$pdf->SetXY(22, 93);
$pdf->Cell(100, 5, $f_ot); 

$pdf->SetXY(79, 107);
$pdf->Cell(100, 5, $f_oblast_and_locality); 

$pdf->SetXY(22, 112);
$pdf->Cell(100, 5, $f_other_locals); 

$pdf->Output('D', 'Soglasie.pdf'); 


?>