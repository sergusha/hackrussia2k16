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
if ($_GET['x'])
	$fromX = $_GET['x'];
else 
	$fromX = 59.987011;
if ($_GET['y'])
	$fromY = $_GET['y'];
else
	$fromY = 30.347672;

if ($_GET['department'])
	$department = $_GET['department'];
else 
	$department = 1;
if ($_GET['addition'])
	$addition = $_GET['addition'];
else
	$addition = "";

//Выбираем больницы со свободными койками в нужном отделении
$query = "SELECT * FROM department_detail_table WHERE department_id=$department";
$sql1 = mysql_query($query);
$destRes = "";
$scrubs_id = 0;
$arr = '';
while($row = mysql_fetch_object($sql1))
{
	$emp = $row->employed;
	$buf = $row->buffer;
	$num = $row->num_of_place;
	if (($emp+$buf)<$num)
	{
		$scrubs_id = $row->scrubs_id;
		$q = "SELECT * FROM scrubs_detail_table WHERE scrubs_id = $scrubs_id";
		$sql2 = mysql_query($q);
		$row2 = mysql_fetch_object($sql2);
		$destRes = $row2->coordX . ',' . $row2->coordY . '|' . $destRes;
		$arr = $row2->id . '|' . $arr;
	}
}
$timeNow = time()+4000;
$urlGoogleApi = "https://maps.googleapis.com/maps/api/distancematrix/json?departure_time=$timeNow&origins=$fromX,$fromY&destinations=$destRes&key=AIzaSyBkYGFvoXHI-PyeGN2synyx_o1_0ZzB5aY";	
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
//echo $current_time . '-' . $current_id . "<br>";
//Выбираем наименьшее время
//Получаем координаты выбранной больницы и отправляем их клиенту
$query = "SELECT coordX, coordY FROM scrubs_detail_table WHERE scrubs_id=$current_id";
$sql = mysql_query($query);
$row = mysql_fetch_object($sql);
$toX = $row->coordX;
$toY = $row->coordY;
//echo $toX . ' ' . $toY . "<br>";
//А перед этим отметим
$query = "UPDATE department_detail_table SET buffer = buffer+1 WHERE scrubs_id=$current_id AND department_id = $department";
$sql3 = mysql_query($query);
$strCoords = "var chicago = {lat: $fromX , lng: $fromY}; var indianapolis = {lat: $toX , lng: $toY};";
$str1 = <<<EOF
<!DOCTYPE html>
<html>
  <head>
    <!-- This stylesheet contains specific styles for displaying the map
         on this page. Replace it with your own styles as described in the
         documentation:
         https://developers.google.com/maps/documentation/javascript/tutorial-->
	<style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      function initMap() {
EOF;

$str2 = <<<EOF
	
        var map = new google.maps.Map(document.getElementById('map'), {
          center: chicago,
          scrollwheel: false,
          zoom: 7
        });
        var directionsDisplay = new google.maps.DirectionsRenderer({
          map: map
        });

        // Set destination, origin and travel mode.
        var request = {
          destination: indianapolis, //to
          origin: chicago, //from
          travelMode: 'DRIVING',
drivingOptions: {
    departureTime: new Date()
  }
        };

        // Pass the directions request to the directions service.
        var directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function(response, status) {
          if (status == 'OK') {
            // Display the route on the map.
            directionsDisplay.setDirections(response);
          }
        });
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCX06Ntv65Qp_T1B_KYEbKHmLaJTJLUE08&callback=initMap"
        async defer></script>
  </body>
</html>
EOF;

print $str1 . $strCoords . $str2;
//print $urlGoogleApi . "<br>" . $html;
//free_to_reserve

?>