<?php
include('db.inc');
if (!$_GET['id'])
	echo -1;
else
{
	$scrubs_id = $_GET['id'];
	$query = "SELECT * FROM department_detail_table WHERE scrubs_id=$scrubs_id";
	$sql = mysql_query($query);
	$res = "";
	while ($row = mysql_fetch_object($sql))
	{
		$query2 = "SELECT name FROM department_table WHERE id=$row->department_id";
		$sql2 = mysql_query($query2);
		$row2 = mysql_fetch_object($sql2);
		
		$employed = $row->employed;
		$num_of_place = $row->num_of_place;
		$buffer = $row->buffer;
		$free = $num_of_place - $buffer - $employed;
		$res = $row->id . '|' . $row2->name . '|' . $employed . '|' . $buffer . '|' . $free . '&' . $res;
		
	}
	
	echo $res;
}
?>