<?php
$db = new mysqli('localhost', 'root', '', 'vance_pos');

if (!$db) {
    die('cannot connect to the database');
}
