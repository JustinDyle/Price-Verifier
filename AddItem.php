<!DOCTYPE html>
<html>
<head>
<title>Add Item</title>
<link rel = "stylesheet" href="styles2.css">
</head>
<body>

<div class="itemadd">
<form method="POST" action="">

        <h2 for="barcode">Barcode:</h2><br>
        <input type="text" id="barcode" name="barcode" required><br>

        <h2 for="item_name">Item Name:</h2><br>
        <input type="text" id="item_name" name="item_name" required><br>

        <h2 for="description">Description:</h2><br>
        <textarea id="description" name="description" required></textarea><br>

        <h2 for="price">Price:</h2><br>
        <input type="number" id="price" name="price" required step="0.01"><br><br><br>

        <button type="submit">Add Item</button>
        <input type="reset" class="reset">

    </form>

<div id="back">
<a href="http://localhost/PriceVerifier/Choices.php">🡸</a>
</div>

<?php

require_once "./additemphp.php";

?>
</div>

</body>
</html>