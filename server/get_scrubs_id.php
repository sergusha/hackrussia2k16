<?php
include("db.inc");

$query = "SELECT * FROM scrubs_table";
$sql = mysql_query($query);
$res = "";
while ($row = mysql_fetch_object($sql))
{
	$res = $row->id . '|' . $row->name . '&' . $res;
}
echo $res;
?>