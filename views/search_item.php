<?php
require "../database/db.php";
if (!empty($_POST['item'])) {
    $query = "SELECT * FROM stock WHERE itemName LIKE '%" . $_POST['item'] . "%' ORDER BY itemName";
    $result = $db->query($query);
    if (!empty($result)) {
        echo "<ul id='items'>";
        foreach ($result as $stock) {
            // echo "<li>" . $stock['item'] . "</li>";
?>

            <li onClick="selectItem('<?php echo htmlspecialchars($stock["stockId"]); ?>', '<?php echo htmlspecialchars($stock["itemName"]); ?>');"><?php echo $stock["itemName"]; ?></li>
<?php
        }
        echo "</ul>";
    }
}
