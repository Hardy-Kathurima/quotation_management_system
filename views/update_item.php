<?php
require '../database/db.php';
session_start();

if (isset($_POST["updateId"])) {
    $order_id = $_POST['updateId'];
    $query = "SELECT * FROM orders WHERE id ='$order_id' ";
    $result = $db->query($query);

    $itemArray = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $itemArray = $row;
        }
        echo json_encode($itemArray);
    } else {
        echo 'no records';
    }
}

if (isset($_POST["itemQuantity"])) {
    $quantity = $_POST["itemQuantity"];
    $itemCost = $_POST["itemCost"];
    $totalCost = $_POST["totalCost"];

    $query = "UPDATE `orders` SET quantity='$quantity',itemCost='$itemCost',totalCost='$totalCost' WHERE id=1";
    $result = $db->query($query);
}
