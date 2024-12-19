<?php

require_once 'user_redirect_logic.php';
require_once 'user_pd_from_db.php'; 

$result = mysqli_query($ctn,"
		UPDATE User
		SET
		cert_saved_at = CURRENT_TIMESTAMP
		
		WHERE id={$user['id']}
	");

if ( !($result) ) {
	echo "Возникла ошибка, попробуйте повторить попытку через некоторое время.";
	exit();
}


require('fpdf/fpdf.php'); 

require_once('fpdi/autoload.php');

$pdf = new \setasign\Fpdi\Fpdi();

$pdf->AddPage();

//Set the source PDF file
$pdf->setSourceFile("cert.pdf");

//Import the first page of the file
$tpl = $pdf->importPage(1);


//Use this page as template
// use the imported page and place it at point 20,30 with a width of 170 mm
$pdf->useTemplate($tpl, 0, 0, 210);



$pdf-> AddFont('DejaVu','','DejaVuSans.php'); 
$pdf-> AddFont('DejaVu','B','DejaVuSans-Bold.php'); 


$pdf-> SetFont('DejaVu','',20); 


$text = iconv('utf-8', 'windows-1251', $pData['grade']." класс");


$text = iconv('utf-8', 'windows-1251', "Настоящий сертификат подтверждает,");
$pdf->SetXY(20, 110);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$text = iconv('utf-8', 'windows-1251', "что учащийся {$pData['grade']} класса");
$pdf->SetXY(20, 121);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$text = iconv('utf-8', 'windows-1251', $School['name']);
$pdf->SetXY(20, 132);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$text = iconv('utf-8', 'windows-1251', $user['lname']);
$pdf-> SetFont('DejaVu','B', 40); 
$pdf->SetXY(20, 147);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$text = iconv('utf-8', 'windows-1251', $user['fname'] . " " . $user['patronym']);
$pdf->SetXY(20, 162);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$prinal_a = "принял";

if ( $user['sex'] == 2 ) $prinal_a = "приняла";


$text = iconv('utf-8', 'windows-1251', $prinal_a . " участие в Политехнической олимпиаде");
$pdf-> SetFont('DejaVu','', 18); 
$pdf->SetXY(20, 177);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$text = iconv('utf-8', 'windows-1251', "школьников 16 апреля 2022 года");
$pdf->SetXY(20, 187);
$pdf->Cell(170, 10, $text, 0, 0, 'C');

$pdf->SetDisplayMode('fullpage');

$pdf->Output('D', 'CertificatePolyOlymp.pdf'); 


?>