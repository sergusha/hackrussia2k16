<?php
if (!$_GET['scrubs_id'] || !$_GET['department_id'])
{
	echo -1;
}
else
{
	$scrubs_id = $_GET['scrubs_id'];
	$department_id = $_GET['department_id'];
	$query = "SELECT buffer FROM department_detail_table WHERE scrubs_id='$scrubs_id' AND department_id='department_id'";
	$row = mysql_fetch_object(mysql_query($query));
	$buffer = $row->buffer;
	if ($empl != buffer)
	{
		$buffer--;
		$query = "UPDATE department_detail_table SET buffer=$buffer WHERE scrubs_id='$scrubs_id' AND department_id='department_id'";
		$dummy = mysql_query($query);
		if (!$dummy)
			echo -1;
		else
			echo 1;
	}
}
?>