<?php
function file_get_contents_curl($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Устанавливаем параметр, чтобы curl возвращал данные, вместо того, чтобы выводить их в браузер.
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

?>


<?php
include('db.inc');

$address = $_POST['call_address'];
$address = str_replace(" ", "+",$address);
echo $address . "<br>";	
//Получим координаты места назначения
$urlGoogleApi = "https://maps.googleapis.com/maps/api/geocode/xml?address=$address&key=AIzaSyBkYGFvoXHI-PyeGN2synyx_o1_0ZzB5aY";
$html = file_get_contents_curl($urlGoogleApi);
$fp = fopen('html.txt', w);
fwrite($fp, $html);
fclose($fp);
$fp = fopen("html.txt",r);
$x=0;
$y=0;
while(!feof($fp))
{
		$str = fgets($fp);
		$dur = strpos($str, "<location>");
		if ($dur)
		{
			//Вычленяем координаты
			$x = fgets($fp);
			$y = fgets($fp);
			$x = trim(substr($x, 9, strpos($x,'</')-9));
			$y = trim(substr($y, 9, strpos($y,'</')-9));
		}
}

echo $x . "-" . $y . "<br>";


$query = "SELECT * FROM coaсh_table WHERE employed=0";
$sql1 = mysql_query($query);
if (!$sql1)
	echo "Fuck1" . "<br>";
else
	echo "O`kay1" . "<br>";
$destRes = "";
$scrubs_id = 0;
$arr = '';
while($row = mysql_fetch_object($sql1))
{
		$destRes = $row->coordX . ',' . $row->coordY . '|' . $destRes;
		$arr = $row->id . '|' . $arr;
}
$timeNow = time()+4000;
$urlGoogleApi = "https://maps.googleapis.com/maps/api/distancematrix/json?departure_time=$timeNow&origins=$x,$y&destinations=$destRes&key=AIzaSyBkYGFvoXHI-PyeGN2synyx_o1_0ZzB5aY";	
$html = file_get_contents_curl($urlGoogleApi);

$fp = fopen('html.txt', w);
fwrite($fp, $html);
fclose($fp);
$fp = fopen('html.txt',r);
//Распарс полученного json

//$toX = 60.007178; 
//$toY = 30.372719;
$current_id =0;
$current_time = 99999999;
$i = 0;

while (!feof($fp))
{
	$str = fgets($fp);
	$dur = strpos($str, "duration_in_traffic"); //Ищем ближайшее включение продолжительности маршрута
	if ($dur)
	{
		$i++;
		$str = fgets($fp);
		$str = trim(fgets($fp));
		$pos = strpos($str, " : ") + 3;
		$time = substr($str, $pos);
		//echo $time . "<br>";
		if ($current_time > $time)
		{
			$current_time = $time;
			$current_id = $i;
		}
	}

}

for ($i=0; $i<$current_id-1; $i++)
{
	//echo $i . '.' . $arr . "<br>";
	$arr = substr($arr, strpos($arr, '|')+1);
}
//echo $arr . "<br>";
$current_id = substr($arr, 0, strpos($arr, '|'));
//Теперь у нас есть наименьшее время в пути и идентификатор кареты скорой помощи, которой быстрее всех добраться до места
//echo $current_time . '-' . $current_id . "<br>";
//Выбираем наименьшее время
//Получаем координаты выбранной больницы и отправляем их клиенту
$insert = "INSERT INTO call_table (address, coach_id, activity) VALUES ('$address', $current_id, 1)";
$sql = mysql_query($insert);
if (!$sql)
	echo "Fuck2" . "<br>";
else
	echo "O`kay2" . "<br>";

//header('Location: example.php');
?>