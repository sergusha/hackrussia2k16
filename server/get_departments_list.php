<?php
include('db.inc');

$query = "SELECT * FROM department_table";
$sql = mysql_query($query);
$res = '';
while ($row = mysql_fetch_object($sql))
{
	$id = $row->id;
	$name = $row->name;
	$res = $res . $id . '|' . $name . '&';
}
header('Content-Type: application/json');
echo  "{ \"text\" : \"" . $res . "\" }";

?>