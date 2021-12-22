<?php
require '../database/db.php';
session_start();
$output = $contactPerson = $location = $email = $region = null;



if (isset($_GET['customerId'])) {
    // $item = $db->real_escape_string($_POST['item']);
    $id = $_GET['customerId'];
    $select = $db->query("SELECT * FROM customers WHERE id = '$id' ");

    $customersArray = array();
    if ($select->num_rows > 0) {
        while ($row = $select->fetch_object()) {


            $customersArray[] = $row;
        }
        echo json_encode($customersArray);
    } else {
        echo 'no records';
    }
}
