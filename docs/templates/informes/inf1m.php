<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer el título de la hoja
$sheet->setTitle('Materiales del mes');

//estilos 
// Agregar color de fondo a la celda A1
$backgroundOrange = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => 'FF5733'],
        // Color amarillo
    ],
];
// título
$sheet->setCellValue('A1', 'Materiales del mes');
$sheet->mergeCells('A1:H1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
$sheet->getStyle('A1')->applyFromArray($backgroundOrange);
// Total de gastos 
$sheet->setCellValue('A2', 'Total de gastos');
$sheet->getStyle('A2')->getFont()->setBold(true);
$sheet->setCellValue('B2', 'valor de prueba');
$sheet->mergeCells('B2:D2');
$sheet->getStyle('B2')->getAlignment()->setHorizontal('center');
// Total de materiales
$sheet->setCellValue('E2', 'Total de Materiales');
$sheet->getStyle('E2')->getFont()->setBold(true);
$sheet->setCellValue('F2', 'valor de prueba');
$sheet->mergeCells('F2:H2');
$sheet->getStyle('F2')->getAlignment()->setHorizontal('center');
// nombrear encabezados
$sheet->setCellValue('A3', 'Nombre del material');
$sheet->getStyle('A3')->getFont()->setBold(true);
$sheet->setCellValue('B3', 'Tipo de material');
$sheet->getStyle('B3')->getFont()->setBold(true);
$sheet->setCellValue('C3', 'Tunel');
$sheet->getStyle('C3')->getFont()->setBold(true);
$sheet->setCellValue('D3', 'Fecha de registro');
$sheet->getStyle('D3')->getFont()->setBold(true);
$sheet->setCellValue('E3', 'Cantidad');
$sheet->getStyle('E3')->getFont()->setBold(true);
$sheet->setCellValue('F3', 'responsable');
$sheet->getStyle('F3')->getFont()->setBold(true);
$sheet->setCellValue('G3', 'Valor Unitario');
$sheet->getStyle('G3')->getFont()->setBold(true);
$sheet->setCellValue('H3', 'Valor total');
$sheet->getStyle('H3')->getFont()->setBold(true);
// Agregar los datos
/*$sheet->setCellValue('A4', 'Edad:');
$sheet->setCellValue('B4', 30);
$sheet->setCellValue('A5', 'Fecha de Nacimiento:');
$sheet->setCellValue('B5', '1993-05-15');



// Establecer formato de fecha
$sheet->getStyle('B5')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
*/
// Establecer ancho de columnas
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getColumnDimension('G')->setWidth(20);
$sheet->getColumnDimension('H')->setWidth(20);

// Guardar el documento en formato XLSX y enviarlo al navegador
$writer = new Xlsx($spreadsheet);

// Configurar las cabeceras para descargar el archivo directamente
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="example.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>