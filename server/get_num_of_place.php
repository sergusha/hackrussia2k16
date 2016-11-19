<?php
include("db.inc");
if (!$_GET['scrubs_id'] || !$_GET['department_id'])
{
	echo -1;
}
else
{
	$scrubs_id = $_GET['scrubs_id'];
	$department_id = $_GET['department_id'];
	$query = "SELECT buffer, employed, num_of_place FROM department_detail_table WHERE scrubs_id=$scrubs_id AND department_id=$department_id";
	$row = mysql_fetch_object(mysql_query($query));
	$buffer = $row->buffer;
	$empl = $row->employed;
	$num_of_place = $row->num_of_place;
	echo $num_of_place . '|' . $empl . '|' . $buffer;
}
?>