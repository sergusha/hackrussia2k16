<?php
include("db.inc");

$department_id = $_POST['choose_department'];
$scrubs_id = $_POST['choose_scrubs'];
$num_of_place = $_POST['num_of_place'];
$query = "INSERT INTO department_detail_table (department_id, scrubs_id, num_of_place, buffer)  VALUES($department_id, $scrubs_id, $num_of_place, 0)";
$dumm = mysql_query($query);
if ($dumm)
header('Location: example.php');
else
	echo "Fuck...";
?>