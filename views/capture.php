<?php
require "../database/db.php";
require_once "../public/fpdf/fpdf.php";
session_start();



$customerName = $_POST['customerName'];
$customerLocation = $_POST['customerLocation'];
$quotationCost = $_POST['quotationCost'];
$customerPhone = $_POST['customerPhone'];
$customerName = $_POST['customerName'];








if (isset($_POST['customerName']) && isset($_POST['special'])) {
    $customerName = $_POST['customerName'];
    $special = $_POST['special'];
    $salesPerson = $_SESSION['name'];
    $quotationCost = $_POST['quotationCost'];
    $customerLocation = $_POST['customerLocation'];
    $customerPhone = $_POST['customerPhone'];
    if (!empty($_SESSION['add_item'])) {
        $insert = "INSERT INTO `quotation` (customerName,quotationCost,special,salesPerson)  VALUES('$customerName','$quotationCost','$special','$salesPerson') ";
        $result = $db->query($insert);


        // insert into orders

        $stmt = $db->prepare("INSERT INTO `orders` (
            
            `customerName`,`customerRef`, `customerLocation`, `itemId`,`itemName`,`itemCost`,`quantity`,`additionalCost`,`deliveryCost`,`itemCategory`,`totalCost`,`salesPerson`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param(
            "sssisiiiisis",

            $customerName,
            $customerRef,
            $customerLocation,
            $itemId,
            $itemName,
            $itemCost,
            $quantity,
            $additionalCost,
            $deliveryCost,
            $itemCategory,
            $totalCost,
            $salesPerson
        );
        foreach ($_SESSION['add_item'] as $row) {
            $customerName = $row['customerName'];
            $itemName = $row['itemName'];
            $itemCost = $row['itemCost'];
            $quantity = $row['quantity'];
            $totalCost = $row['totalCost'];
            $customerRef = $row['customerRef'];
            $customerLocation = $row['customerLocation'];
            $itemId = $row['itemId'];
            $deliveryCost = $row['deliveryCost'];
            $additionalCost = $row['additionalCost'];
            $itemCategory = $row['itemCategory'];
            $salesPerson = $row['salesPerson'];

            // add new fields


            $stmt->execute();

            // unset($_SESSION['add_item']);
        }
    }
}
