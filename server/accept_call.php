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
$id = $_GET['id']; 
$select = "SELECT address FROM call_table WHERE coach_id = $id";
$sql = mysql_query($select);
$row = mysql_fetch_object($sql);
$address = $row->address;
$address = str_replace(" ", "+",$address);
//Получим координаты из адреса
$urlGoogleApi = "https://maps.googleapis.com/maps/api/geocode/xml?address=$address&key=AIzaSyBkYGFvoXHI-PyeGN2synyx_o1_0ZzB5aY";
$html = file_get_contents_curl($urlGoogleApi);
$fp = fopen('html.txt', w);
fwrite($fp, $html);
fclose($fp);

$fp = fopen("html.txt",'r');
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
//echo $x . "-" . $y . "<br>";
/*
$query = "SELECT * FROM coaсh_table WHERE employed=0";
$sql3 = mysql_query($query);
if (!$sql3)
	echo "Fuck..." . "<br>";
else
	echo "O`kay..." . "<br>";

while($row = mysql_fetch_object($sql3))
{
	echo $row3->id . " " . "<br>";
	if ($row3->id == $id)
	{
		echo $id;
		$fromX = $row3->coordX;
		$fromY = $row3->coordY;
	}
}*/
//echo $fromX . " - " . $fromY ."<br>";
$fromX = $_GET['x'];
$fromY = $_GET['y'];
//echo $x . " - " . $y . "<br>";
//echo $id;
$strCoords = "var chicago = {lat: $fromX , lng: $fromY}; var indianapolis = {lat: $x , lng: $y};";
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

?>


