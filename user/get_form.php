<?php

require_once 'user_redirect_logic.php';
require_once 'user_pd_from_db.php'; 

require('fpdf/fpdf.php'); 

require_once('fpdi/autoload.php');

$pdf = new \setasign\Fpdi\Fpdi();

$pdf->AddPage();

//Set the source PDF file
$pdf->setSourceFile("zayav.pdf");

//Import the first page of the file
$tpl = $pdf->importPage(1);


//Use this page as template
// use the imported page and place it at point 20,30 with a width of 170 mm
$pdf->useTemplate($tpl, 0, 0, 210);

$pdf-> AddFont('TimesNewRomanPSMT','','times.php'); 
$pdf-> SetFont('TimesNewRomanPSMT','',12); 

$text = iconv('utf-8', 'windows-1251', $user['lname']);

$pdf->SetXY(80, 74.5);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $user['fname']);

$pdf->SetXY(80, 80);
$pdf->Cell(100, 5, $text);


$text = iconv('utf-8', 'windows-1251', $user['patronym']);

$pdf->SetXY(80, 86);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $pData['format_bday']);

$pdf->SetXY(80, 92.5);
$pdf->Cell(100, 5, $text);


//У.З.:


$text = iconv('utf-8', 'windows-1251', $School['name']);

$pdf->SetXY(80, 100);
$pdf->Cell(100, 5, $text);


$text = iconv('utf-8', 'windows-1251', $School['town']);

$pdf->SetXY(80, 105);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $pData['grade']." класс");

$pdf->SetXY(80, 110);
$pdf->Cell(100, 5, $text);

//Область
$text = iconv('utf-8', 'windows-1251', $pData['oblast']);

$pdf->SetXY(80, 124);
$pdf->Cell(100, 5, $text);

//Населенный пункт
$text = iconv('utf-8', 'windows-1251', $pData['locality']);

$pdf->SetXY(80, 130);
$pdf->Cell(100, 5, $text);

//Улица
$text = iconv('utf-8', 'windows-1251', $pData['street']);

$pdf->SetXY(80, 135.5);
$pdf->Cell(100, 5, $text);

//Дом
$text = iconv('utf-8', 'windows-1251', $pData['home']);

$pdf->SetXY(80, 141);
$pdf->Cell(100, 5, $text);

//квартира
$text = iconv('utf-8', 'windows-1251', $pData['apartment']);

$pdf->SetXY(80, 147);
$pdf->Cell(100, 5, $text);

//Телефон
$text = iconv('utf-8', 'windows-1251', $pData['phone']);

$pdf->SetXY(80, 155);
$pdf->Cell(100, 5, $text);

//Телефон родителя
$text = iconv('utf-8', 'windows-1251', $pData['phoneParent']);

$pdf->SetXY(80, 165);
$pdf->Cell(100, 5, $text);

//ФИО родителя
$text = iconv('utf-8', 'windows-1251', $pData['nameParent']);

$pdf->SetXY(80, 170);
$pdf->Cell(100, 5, $text);

//Мыло
$text = iconv('utf-8', 'windows-1251', $pData['email']);

$pdf->SetXY(80, 188);
$pdf->Cell(100, 5, $text);

// Выделение Ф, И, О в отдельные ячейки массива $fio
$fio = explode(" ", $pData['teacherIKT']);

if ( count($fio) < 3 ) {
	echo "Укажите полное ФИО преподавателя";
	exit();
}


$text = iconv('utf-8', 'windows-1251', $fio[0]);
// Фамилия учителя ИКТ
$pdf->SetXY(80, 204);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $fio[1]);
// Имя учителя ИКТ
$pdf->SetXY(80, 210);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $fio[2]);
// Отчество учителя ИКТ
$pdf->SetXY(80, 216);
$pdf->Cell(100, 5, $text);

// Выделение Ф, И, О в отдельные ячейки массива $fio
$fio = explode(" ", $pData['classTeacher']);

if ( count($fio) < 3 ) {
	echo "Укажите полное ФИО классного руководителя";
	exit();
}


$text = iconv('utf-8', 'windows-1251', $fio[0]);
// Фамилия классрука 
$pdf->SetXY(80, 244.5);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $fio[1]);
// Имя классрука 
$pdf->SetXY(80, 250);
$pdf->Cell(100, 5, $text);

$text = iconv('utf-8', 'windows-1251', $fio[2]);
// Отчество классрука 
$pdf->SetXY(80, 256);
$pdf->Cell(100, 5, $text);

$pdf->Output('D', 'Zayavka.pdf'); 


?>