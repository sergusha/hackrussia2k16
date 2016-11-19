<?php
include("db.inc");

$name = $_POST['scrubs_name'];
$query = "INSERT INTO scrubs_table (name) VALUES('$name')";
$dumm = mysql_query($query);
if ($dumm)
header('Location: example.php');
else
	echo "Fuck...";
?>