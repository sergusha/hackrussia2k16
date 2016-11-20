<?php
include('db.inc');
if (!$_GET['id'] || !$_GET['x'] || !$_GET['y'])
	echo "{ \"text\" : \"-1\" }";
else
{
	//Обновляем координаты
	$x = $_GET['x'];
	$y = $_GET['y'];
	$id = $_GET['id'];
	$update = "UPDATE coach_table SET coordX = $x, coordY = $y WHERE id=$id";
	//Сканируем вызовы
	$select = "SELECT * FROM call_table WHERE activity=1";
	$sql = mysql_query($select);
	$res = 0;
	while($row = mysql_fetch_object($sql))
	{
		$coach_id = $row->coach_id;
		if ($coach_id == $id)
		{
			$update = "UPDATE coach_table SET employed=1 WHERE id=$id";
			$sql2 = mysql_query($update);
			$res++;
		}
	}
	echo "{ \"text\" : \"" . $res . "\" }";
}
?>