<?php


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
	$department = "";
if ($_GET['addition'])
	$addition = $_GET['addition'];
else
	$addition = "";
	
$toX = 60.007178; 
$toY = 30.372719;

$strCoords = "var chicago = {lat: $fromX , lng: $fromY}; var indianapolis = {lat: $toX , lng: $toY};";
$str1 = <<<EOF
<!DOCTYPE html>
<html>
  <head>
    <!-- This stylesheet contains specific styles for displaying the map
         on this page. Replace it with your own styles as described in the
         documentation:
         https://developers.google.com/maps/documentation/javascript/tutorial-->
    <link rel="stylesheet" href="style.css">
	
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