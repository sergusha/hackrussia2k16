<?php
include("db.inc");

$name = $_POST['department_name'];
$query = "INSERT INTO department_table (name) VALUES('$name')";
$dumm = mysql_query($query);
if ($dumm)
header('Location: example.php');
else
	echo "Fuck...";
?>