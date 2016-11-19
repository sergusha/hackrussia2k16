<?php
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
		$sql2 = "SELECT name FROM department_table WHERE id=$row->id";
		$query2 = mysql_query($sql2);
		$row2 = mysql_fetch_object($sql2);
		
		$employed = $row->employed;
		$num_of_place = $row->name_of_place;
		$buffer = $row->buffer;
		$res = $row->id . '|' . $row2->name . '|' . $employed . '|' . $buffer . '|' . ($num_of_place - $buffer - $employed) . '&';
	}
	echo $res;
}
?>