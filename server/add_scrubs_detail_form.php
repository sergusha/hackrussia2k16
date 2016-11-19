<?php
include("db.inc");

$coordX = $_POST['x_coord'];
$coordY = $_POST['y_coord'];
$scrubs_id = $_POST['choose_scrubs'];
$query = "INSERT INTO scrubs_detail_table (scrubs_id, coordX, coordY)  VALUES($scrubs_id, $coordX, $coordY)";
$dumm = mysql_query($query);
if ($dumm)
header('Location: example.php');
else
	echo "Fuck...";
?>