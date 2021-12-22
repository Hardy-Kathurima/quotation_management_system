<?php
require '../database/db.php';
session_start();




if (isset($_GET['stockId'])) {

    $id = $_GET['stockId'];
    $select = $db->query("SELECT * FROM stock WHERE stockId = '$id' ");

    $itemArray = array();
    if ($select->num_rows > 0) {
        while ($row = $select->fetch_object()) {


            $itemArray[] = $row;
        }
        echo json_encode($itemArray);
    } else {
        echo 'no records';
    }
}
