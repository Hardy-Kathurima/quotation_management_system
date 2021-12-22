<?php

session_start();

$total_price = 0;
$total_delivery = 0;
$total_additional = 0;
$total_cost = 0;

$total_item = 0;

$table = '';
$displayTotal = '';

$table .= '<table  class="table table-bordered table-responsive">
<thead>
    <tr>
        <th scope="col">Item name</th>
        <th scope="col">Costs</th>
        <th scope="col">Quantity</th>
        <th scope="col">Delivery cost</th>
        <th scope="col">Additional cost</th>
        <th scope="col">Category</th>
        <th scope="col">Total Cost</th>
        <th scope="col" class="noprint">Action</th>
    </tr>
</thead>';



if (!empty($_SESSION['add_item'])) {
    foreach ($_SESSION['add_item'] as $key => $values) {

        $table .= '  <tr>
        <th scope="row">' . $values['itemName'] . '</th>
        <td >' . $values['itemCost']  . '</td>
        <td >' . $values['quantity'] . '</td>
        <td >' . $values['deliveryCost']  . '</td>
        <td >' . $values['additionalCost']  . '</td>
        <td >' . $values['itemCategory']  . '</td>
        <td >' . $total_cost = $values['quantity'] * $values['itemCost'] + $values['deliveryCost'] + $values['additionalCost'] . '</td>
        
        <td><button onclick="deleteItem(' . $values['itemId'] . ')" name="delete" id=" ' . $values['itemId'] . ' " class="btn delete btn-danger btn-sm">Remove</button></td>
    </tr>';
        $total_price = $total_price + $total_delivery + $total_additional + $values['quantity'] * $values['itemCost'] + $values['deliveryCost'] + $values['additionalCost'];
        $total_delivery = $total_delivery + $values['deliveryCost'];
        $total_additional = $total_additional + $values['additionalCost'];
    }

    $table .= '   <table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th scope="col">Quotation summary</th>
            <th id="totalCost" scope="col">Cost</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Total delivery cost</th>
            <td id="totalDelivery">' . $total_delivery . '</td>
        </tr>
        <tr>
            <th scope="row">Total additional cost</th>
            <td id="totalAdditional">' . $total_additional . '</td>
        </tr>
        <tr>
            <th scope="row"><Strong>Total Quotation</Strong></th>
            <td id="totalQuotation" class="text-danger text-bold">' . $total_price . '</td>
        </tr>


    </tbody>
</table>';
} else {

    $table .= '<tr>
    <td colspan="8" align="center">No quotations added</td>
    </tr>
   
    ';

    $displayTotal .= '   <table class="table table-bordered table-responsive">
<thead>
    <tr>
        <th scope="col">Quotation summary</th>
        <th id="totalCost" scope="col">Cost</th>

    </tr>
</thead>
<tbody>
    <tr>
        <th scope="row">Total delivery cost</th>
        <td id="totalDelivery">0</td>
    </tr>
    <tr>
        <th scope="row">Total additional cost</th>
        <td id="totalAdditional">0</td>
    </tr>
    <tr>
        <th scope="row"><Strong>Total Quotation</Strong></th>
        <td id="totalQuotation" class="text-danger text-bold">0</td>
    </tr>


</tbody>
</table>';
}

echo $table;
echo $displayTotal;
