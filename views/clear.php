<?php
session_start();

if (isset($_POST['clearData'])) {
    unset($_SESSION['add_item']);
}
if ($_POST["action"] == "delete") {
    foreach ($_SESSION["add_item"] as $key => $value) {
        if ($value['itemId'] == $_POST["itemId"]) {
            unset($_SESSION['add_item'][$key]);
        }
    }
}
