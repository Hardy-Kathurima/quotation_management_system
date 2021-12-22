<?php
require '../database/db.php';
session_start();
if (isset($_POST['customer'])) {
    $customer = $_POST['customer'];


    $table = '<table  class="table container my-4 table-bordered table-responsive">
<thead>
    <tr>
        <th scope="col">Item name</th>
        <th scope="col">Costs</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total Cost</th>
        <th scope="col">Action</th>
    </tr>
</thead>';

    $select = $db->query("SELECT * FROM orders WHERE customerName='$customer' ORDER BY quotationId ");

    if ($select->num_rows > 0) {
        while ($row = $select->fetch_object()) {
            $table .= '  <tr>
            <th scope="row">' . $row->itemName . '</th>
            <td >' . $row->itemCost . '</td>
            <td >' . $row->quantity . '</td>
            <td >' . $row->totalCost . '</td>
          <td>
          <button onclick="editItem(' . $row->quotationId . ')" type="button" class="btn btn-primary">
                   <i class="fa fa-edit icon-white"></i> Edit
               </button>

               <button type="button" class="btn btn-danger">
                   <i class="fa fa-trash icon-white"></i> Delete
               </button>
          </td>
        </tr>';
        }

        echo $table;
    }
}
