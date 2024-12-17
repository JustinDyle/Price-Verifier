<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href="styles.css">
    <title>Barcode</title>

</head>

<body>

<video autoplay loop muted id="sakura">
    <source src="SakuraPetals.mp4" type="video/mp4">
</video>


<div class="enterbarcode">
<form method="POST" action=""> 

        <h1 for = "barcode">Enter Barcode:</h1>
        <input type = "text" id = "barcode" name = "barcode"><br><br><br>

        <button type= "submit">Search</button>
        <input type = "reset" class="reset"><br><br>
        
</form>
<a href="http://localhost/PriceVerifier/AddItem.php" target="_blank">Add Item</a>
</div>

<div id="back">
<a href="http://localhost/PriceVerifier/Choices.php">🡸</a>
</div>


<form id="php">

<?php

require_once "./phpbody.php";

?>

</form>

</body>
</html>
