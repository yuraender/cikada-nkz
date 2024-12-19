<?php
require 'PdfForm.php';

$data = [
    'fill_1' => 'John',
    'fill_2' => 'Smith',
    'fill_3' => 'Teacher',
    'fill_4' => '45',
    'fill_5' => 'male'
];

$pdf = new PdfForm('form.pdf', $data);

$pdf->flatten()
    // ->save('forms/output.pdf')
    ->download("Familiya");


// $fields = $pdf->fields(true);

// echo "Fields: ";
// echo $fields;

?>