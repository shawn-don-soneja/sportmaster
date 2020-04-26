<?php   //Database login file
include '../db_connect.php';
date_default_timezone_set('America/New_York');
//Start Connection
$conn = OpenCon();

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "<script>console.log(' Status: we good')</script>";
}

//=========  TIMETABLE CODE  ===========

//Query statement 
$sqlLocation = "SELECT `LocationName`,`Address`,`ArrivalTime`,`Lat`,`Longitude` FROM `TimetableEntries`";

//Query output
$resultLocation = $conn->query($sqlLocation);

$locationContainer = array();
$outputContainer = array();
$outputContainer['message'] = [];
$outputContainer['on/off'] = [];
$outputContainer['date'] = [];
$locationContainer['Locations'] = [];
$locationContainer['Addresses'] = [];
$locationContainer['ArrivalTime'] = [];
$locationContainer['Lat'] = [];
$locationContainer['Longitude'] = [];

//Styling function for line breaks
//turns out this may have been useless! <br>, even in a string, does the same thing 
function separate($string){
    if ( strpos($string, '|') ) {
        //if it's true, break it up by that char 
        $out = explode('|',$string);
        for($x=0;$x<count($out);$x++){
            print($out[$x]);
            print("<br>");
        }
    }else{
        print($string);
    }
}

//Iterate over your output if there's data
if ($resultLocation->num_rows > 0) {

    while($row = $resultLocation->fetch_assoc()) {
        if($row['LocationName'] != ""){
            array_push($locationContainer['Locations'],$row['LocationName']); 
            array_push($locationContainer['Addresses'],$row['Address']);
            array_push($locationContainer['ArrivalTime'],$row['ArrivalTime']); 
            array_push($locationContainer['Lat'],$row['Lat']); 
            array_push($locationContainer['Longitude'],$row['Longitude']); 
        }
    }
    
    //print("</div>");
} else {
    echo "0 results";
}

//load message 
//retrieve message


//Query statement 
$sqlMsg= "SELECT * FROM `updateMessage`";

//Query output
$resultMsg = $conn->query($sqlMsg);

if ($resultMsg->num_rows > 0) {

    while($row = $resultMsg->fetch_assoc()) {

        array_push($outputContainer['message'],$row['Message']);
        array_push($outputContainer['on/off'],$row['on/off']);
        array_push($outputContainer['date'],$row['date']);
        
    }
    
    
    
} 



//end update message

//=========  Hours  CODE  ==========
$hoursInfo = array();
$hoursInfo['hours'] = array();
$hoursInfo['day'] = array();


$hoursPull = "SELECT * FROM `baitRunnersHours`  ";

//Query output
$resultHours = $conn->query($hoursPull);

if ($resultHours->num_rows > 0) {

    while($row = $resultHours->fetch_assoc()) {
        array_push($hoursInfo['hours'],$row['Hours']);
        array_push($hoursInfo['day'],$row['Day']);
    }
    
}

//=========  MAP CODE  ==========
 

//load last position


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
    print("<script>  console.log('successful insert'); </script>");
}

}



CloseCon($conn);

?>
<head>
<title>Bait Runners</title>
<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163322175-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-163322175-1');
    </script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-GSCV67V');</script>
<!-- End Google Tag Manager -->


<script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
var pos;
var datVar;

var realL = <?php print($realLat) ?> ;
var realLn = <?php print($realLng) ?> ;
function initMap(){
  // The location of Uluru
  var uluru = {lat: realL, lng: realLn};
  
  var phillyCenter = {lat:39.863371,lng:-75.243236};
  
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 10.5, center: phillyCenter});
  // The marker, positioned at Uluru
  var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
  
  var truck = 'http://maps.google.com/mapfiles/ms/icons/truck.png';
  var marker = new google.maps.Marker({position: uluru, map: map, icon: truck});
  
  var infowindow = new google.maps.InfoWindow({
          content:"Bait Runners Truck"
        });
  <?php
  
    for($i=0;$i<count($locationContainer['Lat']);$i++){
            print("
            var markerPosition = {lat: ".$locationContainer['Lat'][$i].",lng:".$locationContainer['Longitude'][$i]."};
            
            var locationMarker".$i." =
            
            new google.maps.Marker({
    			position: markerPosition,
    			map: map,
    			icon: 'http://maps.google.com/mapfiles/kml/paddle/".($i+1).".png'
			}); 
			
			
			google.maps.event.addListener(locationMarker".$i.", 'mouseover', function() {
              infowindow.open(map,locationMarker".$i.");
              infowindow.setContent('".$locationContainer['Locations'][$i]."');
            });
            
            ");
        }
    ?>
        /*
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map,marker);
        });
        */
        
        
        //map.setCenter(uluru);
    
}//end initMap

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
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inria+Sans&display=swap" rel="stylesheet">
  <!--fav icon shit-->
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <!--main css--> 
  <style>
body{
  margin:0;
  background:linear-gradient(160deg, white,lightblue);
  min-height:100vh;
  font-family:"Inria Sans";
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
#backButton{position:absolute;top:15px;left:8px;font-size:14px;cursor:pointer;display:flex;align-items:center;background:;}
#backButton:hover{opacity:0.5;}
#update{margin:auto;width:50%;min-height:50px;margin-top:10px;border:1px solid red;padding:10px;display:flex;align-items:center;border-radius:3px;background:rgba(255,255,255,0.7);}
.headerContainer{min-height:200px;margin:auto;width:80%;margin-top:40px;margin-bottom:70px;position:relative;background:white;overflow:visible;border-radius:3px;}
.container{min-height:400px;margin:auto;width:80%;margin-top:40px;margin-bottom:70px;position:relative;}
#table,#map{width:49.0%;min-height:530px;display:inline-block;border-radius:3px;line-height:0.7;box-shadow:0px 0px 10px 0px rgba(150,150,150,0.7);}
#table{background:rgba(173, 216, 230,0.3);}
#table .block{display:inline-block;min-height:100px;text-align:center;}
.block .element{display:flex;border-top:1px solid gray;height:<?php print(400 / count($locationContainer['Locations']));print("px") ?>;align-items:center;justify-content:center;line-height:1.2;}
.location .element{font-size:11px;border-right:1px solid gray;}
.time .element{font-size:14px;border-right:1px solid gray;border-right:0px solid blue;}
.headerContainer .element{width:33.3%;height:200px;background:white;float:left;box-shadow:0px 0px 5px 0px gray;position:relative;border-radius:3px;}
h2{font-weight:lighter;background:none;margin-top:15px;}

#table h4{font-weight:lighter;font-size:14px;}
.block h4{}
#map{float:right;}
#mapTime{width:24%;right:00px;text-align:center;position:absolute;bottom:-30px;padding:5px;background:lightgray;color:gray;border-radius:4px;font-size:13px;}
h4 i{color:gray;}


/* code for button */

#recordTime{
    background-color:darkblue;
    height:1.2rem;
    width:4rem;
}

/* end code for button */
@media screen and (max-width:1000px){
  
  body{}
  .container{width:100%;}
  #table{padding:1px;}
  #table,#map{display:block;margin:auto;width:95%;height:400px;}
  h2{font-size:14px;margin-top:15px !important;}
  #table h4{font-size:11px;}
  #map{float:none;margin-top:20px;}
  #mapTime{width:60%;}
    #logo{
        width:90%;
        margin-top:10px;
    }
    .headerContainer{min-height:600px;margin:auto;width:95%;margin-top:10px;margin-bottom:30px;}
    .headerContainer .element{width:100%;height:200px;background:white;box-shadow:0px 0px 5px 0px gray;position:relative;border-radius:3px;}

}
@media screen and (min-width:1600px){
  body{}
  #table,#map{min-height:300px;}
  .block .element{height:55px;}
}
  </style>
  
  <!--main script--> 
  
</head>
<html><body onload='initMap()'>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-GSCV67V"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id='logo'></div>
<div id='backButton' >&lt;&nbsp;<a href='/index.php'> <img src='/images/sportLogo_no_background.png' width='80px' style=''/></a></div>

<style>
.headerContainer h3, .headerContainer p, .headerContainer h2{margin:10px;color:;}
.headerContainer h3{font-weight:normal;}
.headerContainer p{}
.headerContainer .lowerElement{box-shadow:0px 0px 0px transparent;}
.headerContaienr .higherElement{}
.headerContainer .customerImage{
    height:50%;width:33.3%;
    float:left;
    background-size: cover !important;
    background-position:center !important;
    background-repeat: no-repeat !important;
    position:relative;
    z-index:1 !important;
}
</style>
<div class='headerContainer'>
    <div class='element higherElement' style='z-index:5;'>
        <h2>Bait Runners</h2>
        <span style='font-size:13px'>
        <p>Local bait service in Philly.<br> We bring bait straight to you, at the best spots in town. You'll see us on the map below when we're on route.</p>
        <p style='position:absolute;bottom:8px;color:gray;'>Call or email to place your bait order with us!<br>Minimum order value is $50</p>
        </span>
    </div>
    <div class='element lowerElement' style='z-index:1;'>
        <div class='customerImage' style='background:url(/images/customers/1.png)'></div>
        <div class='customerImage' style='background:url(/images/customers/9.png)'></div>
        <div class='customerImage' style='background:url(/images/customers/4.png)'></div>
        <div class='customerImage' style='background:url(/images/customers/6.png)'></div>
        <div class='customerImage' style='background:url(/images/customers/7.png)'></div>
        <div class='customerImage' style='background:url(/images/customers/8.png)'></div>
        
    </div>
    <div class='element higherElement' style='z-index:5;'>
        <h3>Phone</h3>
        <p style='font-size:13px;'>267-224-0003</p>
        <h3 style='margin-bottom:0;'>Route Times</h3>
        <span style='font-size:10px;'>
            <div style='width:50%;float:left;'>
            <?php 
                //container of day abbreviations 
                $days = ["Mon:", "Tues:", "Wed:", "Thurs:","Fri:","Sat:","Sun:"];
                
                //iterate over Mon - Thurs hours
                for($q=0;$q<4;$q++){
                    //print($days + ":" + );
                    //print("HELLO");
                    print("<p>".$days[$q]." ".$hoursInfo['hours'][$q]."</p>");
                    //print();
                }
                //print("yes");
                print("<script>console.log('total:".count($hoursInfo)."')</script>");
                print("<script>console.log('hours:".count($hoursInfo['hours'])."')</script>");
                print("<script>console.log('".$hoursInfo['hours'][3]."')</script>");
            ?>
            </div>
            <div style='width:50%;float:left;'>
                
            <?php 
            //iterate over Mon - Thurs hours
                for($q=4;$q<7;$q++){
                    //print($days + ":" + );
                    //print("HELLO");
                    print("<p>".$days[$q]." ".$hoursInfo['hours'][$q]."</p>");
                    //print();
                }
            ?>
            </div>
            
            
        </span>
    </div>
</div>
<div style="text-align:center"> <?php

if($outputContainer['on/off'][0] == 'true'){
    //print();
    print("<center style='margin-top:20px;color:red;font-weight:bold'>Update</center>");
    print("<div id='update'>".$outputContainer['message'][0]."</div>");
}


?>
</div>
<!--
<center style='margin-top:20px;color:red;font-weight:bold'>Update</center>
<div id='update'>This update box can handle as many words as you need it toit will stretch if you need it to.another set of words<br>another set of words</div>
-->

<style>.header{border:1px solid lightgray;min-height:80px;background:white;margin:0;}</style>
<div class='container'>
  <div id='table'>
    <div class='header'>
    <center><h2 style='padding:0px;'>Bait Runners Route</h2></center>
    <h4 style='margin-right:10px;padding:0;float:left;margin:5px;'><i>* indicates tide-based stops</i></h4> 
    </div>
    <div class='block location' style='float:left;width:35%;'>
      <h4 style=''>Location</h4>
    <?php
        for($i=0;$i<count($locationContainer['Locations']);$i++){
            print("<div class='element'>".$locationContainer['Locations'][$i]."</div>");
        }
    ?>
    </div>
    <div class='block location' style='float:left;width:45%;'>
      <h4 style=''>Address</h4>
    <?php
        for($i=0;$i<count($locationContainer['Locations']);$i++){
            print("<div class='element'>".$locationContainer['Addresses'][$i]."</div>");
        }
    ?>
    </div>
    <div class='block time' style='float:left;width:20%;'>
      <h4>Time</h4>
      <?php
        for($i=0;$i<count($locationContainer['Locations']);$i++){
            print("<div class='element'>".$locationContainer['ArrivalTime'][$i]."</div>");
        }
      ?>
    </div>
  </div> 
  
   <div id="map"></div>
   <br><br>
  <div id='mapTime'>Location as of: <br> <?php print($outputContainer['time'][count($outputContainer['time']) - 1]);?></div>
  
     
     
     
</div>
<center>Questions? Your fishing spot not listed?<br>Call us at 267-224-0003</center><br><br>
</body></html>