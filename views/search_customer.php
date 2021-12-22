<?php
require "../database/db.php";
if (!empty($_POST['customerName'])) {
    $query = "SELECT * FROM customers WHERE customerName LIKE '%" . $_POST['customerName'] . "%' ORDER BY customerName";
    $result = $db->query($query);
    if (!empty($result)) {
        echo "<ul id='customers'>";
        foreach ($result as $customer) {

?>

            <li onClick="selectCustomer('<?php echo htmlspecialchars($customer["customerId"]); ?>', '<?php echo htmlspecialchars($customer["customerName"]); ?>');"><?php echo $customer["customerName"]; ?></li>
<?php
        }
        echo "</ul>";
    }
}
