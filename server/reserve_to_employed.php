<?php
if (!$_GET['scrubs_id'] || !$_GET['department_id'])
{
	echo -1;
}
else
{
	$scrubs_id = $_GET['scrubs_id'];
	$department_id = $_GET['department_id'];
	$query = "SELECT buffer, employed FROM department_detail_table WHERE scrubs_id='$scrubs_id' AND department_id='department_id'";
	$row = mysql_fetch_object(mysql_query($query));
	$buffer = $row->buffer;
	$empl = $row->employed;
	if ($empl != buffer)
	{
		$buffer--;
		$empl++;
		$query = "UPDATE department_detail_table SET buffer=$buffer, employed=$empl WHERE scrubs_id='$scrubs_id' AND department_id='department_id'";
		$dummy = mysql_query($query);
		if (!$dummy)
			echo -1;
		else
			echo 1;
	}
}
?>