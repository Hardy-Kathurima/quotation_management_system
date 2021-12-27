<?php
require '../database/connect_item.php';
if (!isset($_SESSION['add_item'])) {
    session_start();
}


if (empty($_SESSION['add_item'])) {
    $_SESSION['add_item'] = array();
}

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];
    $found = false;
    foreach ($_SESSION['add_item'] as $key => $value) {
        if ($value['itemId'] == $_POST['itemId']) {
            $value['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if ($found == false) {
        array_push(
            $_SESSION['add_item'],

            [
                "customerName" => $_POST['customerName'],
                "customerPhone" => $_POST['customerPhone'],
                "customerRef" => $_POST['customerRef'],
                "customerLocation" => $_POST['customerLocation'],
                "itemId" => $_POST['itemId'],
                "quantity" => $_POST['quantity'],
                "additionalCost" => $_POST['additionalCost'],
                "itemCost" => $_POST['itemCost'],
                "deliveryCost" => $_POST['deliveryCost'],
                "itemName" => $_POST['itemName'],
                "itemCategory" => $_POST['itemCategory'],
                "totalCost" => $_POST['totalCost'],
                "salesPerson" => $_SESSION['name']

            ]
        );
    }
}
