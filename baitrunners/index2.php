
<html><body>
<head>
 
 <?php   //Database login file
include 'db_connect.php';
date_default_timezone_set('America/New_York');
//Start Connection
$conn = OpenCon();

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "<script>console.log(' Status: we good')</script>";
}
//load last position

$outputContainer = array();
$outputContainer['time'] = [];
$outputContainer['lat'] = [];
$outputContainer['lng'] = [];
$sqlPull = "SELECT * FROM `updatedLocation`  ";

//Query output
$resultPull = $conn->query($sqlPull);
//Iterate over your output if there's data
if ($resultPull->num_rows > 0) {

    while($row = $resultPull->fetch_assoc()) {

           
        array_push($outputContainer['time'],$row['Time']); 
        array_push($outputContainer['lat'],$row['Lat']); 
        array_push($outputContainer['lng'],$row['Lng']); 
        
    }
    
   
}
$realLat = $outputContainer['lat'][count($outputContainer['lat']) - 1];
$realLng = $outputContainer['lng'][count($outputContainer['lng']) - 1];

//send brady
$lng = $_GET['lng'];
$lat = $_GET['lat'];
  if ($lng == "" or $lat == ""){
    
}else if ($lng != "" && $lat != ""){
   
$today = date("F j, Y, g:i a"); 


$sql = "INSERT INTO `updatedLocation`(`Lat`, `Lng`, `Time`) VALUES (".$lat.",".$lng.",'".$today."')";

//Query output
$result = $conn->query($sql);
if($result == 1){
     header('Location: https://sportmasterbaitandtackle.com/baitrunners/index2.php');
    print("<script>  console.log('successful insert'); </script>");
    
}


CloseCon($conn);
}

    






?>
<br>

<script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var pos;
     var datVar;
      function loadPosition(login){
          var login = document.getElementById("usrPwd").value;
          if (navigator.geolocation && login == "recludo12") {
          navigator.geolocation.getCurrentPosition(function(position) {
              
            pos = {
              lat: position.coords.latitude,
              
              lng: position.coords.longitude
              
            };
            
            
            window.location.href = "https://sportmasterbaitandtackle.com/baitrunners/index2.php?lat=" + pos.lat + "&lng=" + pos.lng ;
            
            
          });
      };
      }
      
      
      var realL = <?php print($realLat) ?> ;
          var realLn = <?php print($realLng) ?> ;
         
      function initMap() {
          
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: realL, lng: realLn},
          zoom: 15
        });
     //set marker
        var bradPosition = {lat: realL,lng: realLn};
	        var marker = new google.maps.Marker({
			position: bradPosition,
			map: map,
			title: 'Bait Runner Position'
			});  
			
			//end marker
			marker.setMap(map);
          
          var map, infoWindow;
      
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            // var pos = {
            //   lat: position.coords.latitude,
            //   lng: position.coords.longitude
            // };
            console.log("lat " + pos.lat);
            console.log("long " + pos.lng);
            
            
            
            
            
            
            
            
            
            infoWindow.setPosition(pos);
            infoWindow.setContent('BaitRunner Van');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
          
      
      
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_28X1v3fbmMomddEYRp8wsijHevU_lJ8&callback=initMap">
    </script>
   
  
  <meta name="viewport" content="initial-scale=1.0">
  
  <!--main css--> 
  <style>
body{
  margin:0;
  background:linear-gradient(160deg, white,lightblue);
  min-height:100vh;
  font-family:"Helvetica";
}
#logo{
  width:30%;
  max-width:440px;
  min-height:270px;
  border:0px solid red;
  height:220px;
  margin:auto;
  text-align:center;
  background:url('/images/baitlogo.png') center no-repeat;
  background-size:100%;
  opacity:1;
}
#backButton{position:absolute;top:15px;left:8px;font-size:14px;cursor:pointer;}
#backButton:hover{opacity:0.5;}
#update{margin:auto;width:50%;min-height:50px;margin-top:10px;border:1px solid red;padding:10px;display:flex;align-items:center;border-radius:3px;background:rgba(255,255,255,0.7);}
.container{min-height:400px;margin:auto;width:80%;margin-top:40px;margin-bottom:70px;position:relative;}
#table,#map{width:49.0%;min-height:400px;background:rgb(230,230,230);display:inline-block;border-radius:3px;line-height:0.7;box-shadow:0px 0px 10px 0px rgba(150,150,150,0.7);}
#table{}
#table .block{width:50%;display:inline-block;background:rgba(173, 216, 230,0.3);min-height:100px;text-align:center;}
.block .element{display:flex;border-top:1px solid gray;height:40px;align-items:center;justify-content:center;line-height:1.2;}
.location .element{font-size:10px;border-right:1px solid gray;}
h2{font-weight:lighter;background:none;margin-top:15px;}

#table h4{font-weight:lighter;font-size:14px;}
.block h4{text-decoration:underline;}
#map{float:right;}
#mapTime{width:14%;right:00px;text-align:center;position:absolute;bottom:-30px;padding:5px;background:lightgray;color:gray;border-radius:4px;font-size:13px;}
h4 i{color:gray;}


/* code for button */

#recordTime{
    background-color:darkblue;
    height:1.5rem;
    width:3rem;
    border-radius:15px;
   padding-left:1.5rem;
   padding-right:1.5rem;
   padding-top:.5rem;
   padding-bottom:.3rem;
  margin:auto;
    cursor:pointer;
    text-align:center;
}

/* end code for button */
@media screen and (max-width:1000px){
  body{}
  #table{padding:1px;}
  #table,#map{display:block;margin:auto;width:80%;min-width:300px;height:380px;}
  h2{font-size:14px;margin-top:15px !important;}
  #table h4{font-size:11px;}
  #map{float:none;margin-top:20px;}
    #logo{
        width:90%;
        margin-top:10px;
    }
}
@media screen and (min-width:1600px){
  body{}
  #table,#map{height:500px;}
  .block .element{height:55px;}
}
  </style>
  
  <!--main script--> 
  
</head>

<div id='logo'></div>
<div id='backButton'><a href='/index.php'>&lt; Back to Home</a></div>
<center style='margin-top:10px;line-height:1.3;'>Servicing the locations below.<br>The Bait Runners' location will show on the map when they're servicing locations.</center>

<!--
<center style='margin-top:20px;color:red;font-weight:bold'>Update</center>
<div id='update'>This update box can handle as many words as you need it toit will stretch if you need it to.another set of words<br>another set of words</div>
-->

<div class='container'>
  <div id='table'>
    <center><h2 style='padding:0px;'>Timetable:</h2></center>
    <h4 style='margin-left:10px;margin-bottom:10px;padding:0px;float:left;margin:5px;'><i>Routes are run Mon-Fri</i></h4> 
    <h4 style='margin-right:10px;margin-bottom:10px;padding:0;float:right;margin:5px;'><i>* indicates tide-based stops</i></h4> 
    <br>
    <div class='block location' style='float:left;'>
      <h4 style=''>Location</h4>
      <div class='element'>123 Sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
      <div class='element'>123 Sample  sample street, Philadelphia, PA 10010</div>
    </div>
    <div class='block time' style='float:right;'>
      <h4>Time</h4>
      <div class='element'>8:30am</div>
      <div class='element'>9:30am</div>
      <div class='element'>10:30am</div>
      <div class='element'>11:30am</div>
      <div class='element'>1:30pm</div>
      <div class='element'>2:30pm</div>
      <div class='element'>2:30pm</div>
    </div>
  </div> 
  
   <div id="map"></div>
   
  <div id='mapTime'>Location as of 10:12am</div>
  <form action="https://sportmasterbaitandtackle.com/baitrunners/">
     
    <input name='lat' id='lat' type="text" hidden>
    <input name='lng' id='lng' type="text" hidden>
     </form>
     
     <script>
         //set pasword value for loadPosition
         var tempVar = document.getElementById("usrPwd").value;
         
         </script>
         <div style="margin:auto;text-align:center;">
             Enter Password: <input name='pwd' id='usrPwd' type="text" value="Password" >
             </div>
     
     <br>
      <div id='recordTime'   onclick='loadPosition("helo");' style='color:white'>Update </div>
      <br>

     <div id='datTime' style="margin:auto;text-align:center;">Location as of <?php print($outputContainer['time'][count($outputContainer['time']) - 1]);?></div>
     
     
</div>
<center>Questions?<br>Call us at XXX-XXX-XXXX</center><br><br>
</body></html>