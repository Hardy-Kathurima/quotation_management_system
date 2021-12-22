<?php
require "../database/db.php";
session_start();

if (isset($_POST['displayQuote'])) {

    $table = '<table class="table table-bordered table-responsive">
<thead>
    <tr>
    <th scope="col">Quotation No</th>
    <th scope="col">Customer Name</th>
    <th scope="col"> Quotation Date</th>
    <th scope="col">Quotation Cost</th>
    <th scope="col">Delivery Date</th>
    <th scope="col">Quotation Status</th>
    <th class="text-center" scope="col">Process</th>
    </tr>
</thead>';

    $select = $db->query("SELECT * FROM quotation ORDER BY quotationNo ");

    $sum = $db->query("SELECT SUM(quotationCost) as total FROM quotation");
    $total_quotation = "";
    if ($sum->num_rows > 0) {
        while ($row = $sum->fetch_object()) {
            $total_quotation .= $row->total;
        }
    }

    $quotations = $select->num_rows;
    if ($select->num_rows > 0) {
        while ($row = $select->fetch_object()) {
            $table .= ' <tr>
           <th scope="row" class="text-center">#' . $row->quotationNo . '</th>
           <td>' . $row->customerName . '</td>
           <td>' . $row->quotationDate . '</td>
           <td class="text-danger text-center">' . $row->quotationCost . '</td>
           <td>' . $row->deliveryDate . '</td>
           <td>' . $row->quotationStatus . '</td>
           <td>
               <a href="update_quote.php?customer=' . $row->customerName . '" type="button" class="btn btn-primary">
                   <i class="fa fa-pencil-square-o icon-white"></i> Adjust
               </a>

               <a href="#" type="button" class="btn btn-success">
                   <i class="fa fa-paper-plane icon-white"></i> Process
               </a>
           </td>
       </tr>';
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
                <th scope="row">Total Quotation</th>
                <td id="totalQuotations">' . $quotations . '</td>
            </tr>
           
            <tr>
                <th scope="row"><Strong>Total Quotation Cost</Strong></th>
                
                <td id="totalQuotationCost" class="text-danger text-bold">' . $total_quotation . '</td>
            </tr>
    
    
        </tbody>
    </table>';
    } else {
        $table .= '<tr>
        <td colspan="8" align="center">No quotations added</td>
        </tr>
       
        ';
    }
    $table .= '</table>';
    echo $table;
}
