<?php
require "../database/db.php";
require_once "../public/fpdf/fpdf.php";
session_start();
if (isset($_GET['customer']) && isset($_GET['phone']) && isset($_GET["location"]) && isset($_GET['quotation']) && isset($_GET['ref'])) {
    $customer = $_GET['customer'];
    $phone = $_GET['phone'];
    $location = $_GET['location'];
    $quotation = $_GET['quotation'];
    $ref = $_GET["ref"];
    $customerData = $_GET['customerData'];
    $allDetails = json_decode($customerData);
}


$pdf = new FPDF('P', 'mm', 'A4');

$pdf->AddPage();

$pdf->SetFont('Arial', '', 14);




$pdf->Cell(190, 50, "QUOTATION # " . $quotation, 0, 1, "C");

$pdf->Cell(20, 7, $customer, 0, 1, "L");
$pdf->Cell(20, 7, "Ref: " . $ref, 0, 1, "L");
$pdf->Cell(20, 7, "Phone: " . $phone, 0, 1, "L");
$pdf->Cell(20, 7, "Location: " . $location, 0, 1, "L");

$pdf->Ln(5);

$pdf->Cell(40, 10, "Description", 0, 0, "L");
$pdf->Cell(40, 10, "Cost", 0, 0, "L");
$pdf->Cell(40, 10, "Quantity", 0, 0, "L");
$pdf->Cell(40, 10, "Amount", 0, 1, "L");


foreach ($allDetails as $key => $value) {
    $pdf->Cell(40, 10, $value->itemName, 0, 0, "L");
    $pdf->Cell(40, 10, $value->itemCost, 0, 0, "L");
    $pdf->Cell(40, 10, $value->quantity, 0, 0, "L");
    $pdf->Cell(40, 10, $value->itemCost * $value->quantity, 0, 1, "L");
}



$pdf->Ln(2);


$total_price = 0;
$total_delivery = 0;
$total_additional = 0;
foreach ($allDetails as $key => $value) {
    $total_delivery = $total_delivery + $value->deliveryCost;
    $total_additional = $total_additional + $value->additionalCost;
    $total_price = $total_price + $total_delivery + $total_additional + $value->quantity * $value->itemCost + $value->deliveryCost + $value->additionalCost;
}


$pdf->Cell(50, 30, "TOTAL", 0, 0, "L");
$pdf->Cell(80, 30, $total_price, 0, 1, "R");
$pdf->Ln(3);

$pdf->Cell(190, 10, "Served By Toto", 0, 1, "C");
$pdf->Cell(190, 10, "VANCE COMPUTERS", 0, 1, "C");
$pdf->Cell(190, 10, "CONTACT: 0722457790", 0, 1, "C");




$pdf->Output();
