<!DOCTYPE html>
<?php
include "/contentControl/db_connect.php";

//Start Connection
$conn = OpenCon();

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    //echo "<b>Connection Status:</b> we good<br>";
}

//Query statement
$sql = "SELECT `Content`,`Category`,`Date` FROM `master`";

//Query output
$result = $conn->query($sql);

$outputContainer = array();
$outputContainer['Hours'] = [];
$outputContainer['Pricing'] = [];
$outputContainer['Pictures'] = [];
$outputContainer['News'] = [];
//new sections
$outputContainer['HelpInfo'] = [];
$outputContainer['Links'] = [];
$outputContainer['Partners'] = [];

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
if ($result->num_rows > 0) {
    //print("<div style='height:300px;width:450px;overflow:scroll;border:1px solid yellow;'>");

    //echo "_";

    //data of each row
    while($row = $result->fetch_assoc()) {
        //echo separate($row["Content"]);
        //implementing function from above
        //print("<span style='height:40px;width:400px;border:1px solid blue;'>");


        //echo $row["Category"];
        //echo "<br>";
        if($row["Category"] == "Hours"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['Hours'],$input);
            //print("yes");
        }else if($row["Category"] == "Pricing"){
            //echo $row["Date"];
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['Pricing'],$input);
        }else if($row["Category"] == "News"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['News'],$input);
        }else if($row["Category"] == "Pictures"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['Pictures'],$input);
        }else if($row["Category"] == "HelpInfo"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['HelpInfo'],$input);
        }else if($row["Category"] == "Links"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['Links'],$input);
        }else if($row["Category"] == "Partners"){
            $input = [$row["Content"],$row["Date"]];
            array_push($outputContainer['Partners'],$input);
        }

        /*
        echo $row["Content"];
        echo "  ";
        echo "<span style='color:lightgray;font-size:18px;'>";
        echo $row["Category"];
        echo "</span>";
        echo "<br>______________________<br>";
        //print("</span>");
        */
    }

    //print("</div>");
} else {
    echo "0 results";
}



CloseCon($conn);
?>

<html>
<body onload='myMap()'>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-GSCV67V"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

<head>
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportmaster</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--fav icon shit-->
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#ffffff">
    <!--end fav icon shit-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV108IEQ-yUAvKsY-g7WSzPuFnzvuhiZk&callback=myMap"></script>
    <script>
//scroller code
function continueScroll(){
  setInterval(pageScroll,20);
  setInterval(resetScroll,4410)
}
function pageScroll() {
    var carousel = document.getElementById("carousel");
    carousel.scrollBy(1,0);
    //scrolldelay = setTimeout(pageScroll,20);
    //setTimeout(resetScroll,3000);
}
function resetScroll(){
  var carousel = document.getElementById("carousel");
  carousel.scrollTo(0,0);
}
//continueScroll();
//end scroller code

//google map code
function myMap() {
var mapProp= {
  center:new google.maps.LatLng(40.021582,-75.054464),
  zoom:10,
};
var marker = new google.maps.Marker({
    position: {lat: 40.021582, lng: -75.054464},
    map: map,
    title: 'Hello World!'
  });
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

marker.setMap(map);
}
//myMap();
//end google map code
    </script>
    <style>
body{
  margin:0;
  background:linear-gradient(rgba(0,120,200,0.0) 15%,rgba(0,221,221,0.2) 50%, rgba(0,120,200,0.3) 80% );
  font-family:"Helvetica";
  line-height:1.5;

}
a{
    text-decoration:none;
    margin-top:5px;
}
h1,h2,h3,h4{
    color:rgba(0,0,0,0.70);
}
h4{
  margin:10px;
  font-size:19px;
}
h5{
  margin:10px;
  color:rgba(50,50,90,1);
  font-weight:normal;
}
#logo{
  display:flex;
  align-items:center;
  margin:auto;
  background:white;
  border:0px solid green;
  width:37%;
  min-width:400px;
  max-width:500px;
  height:260px;
}
.gridBlock{
  position:relative;
  height:100%;width:100%;
  background:linear-gradient(30deg, white, rgba(255,255,255,1));
  box-shadow: 1px 2px 6px 0px rgba(0,00,0,0.2);
  border-radius:3px;
}
.grid1{
  display:grid;
  /*rows - columns*/
  grid-template: 1fr 1fr / 1fr 1fr 1fr;
  grid-gap: 10px 20px;
  height:100%;
  width:90%;
  margin:auto;
  min-height:350px;
  border:0px solid blue;
  margin-top:40px;
}
.picScroller{
  height:100%;
  min-height:200px;
  border:0px solid green;
}
.carousel{
  height:200px;
  width:94%;
  margin:auto;
  margin-top:50px;
  margin-bottom:50px;
  border:0px solid green;
}
.slider{display:flex;}
.block{
  position:relative;
  height:100%;
  width:20%;
  border:0px solid red;
  float:left;
  overflow:hidden;
}
.imgContainer{
    background:rgba(255,255,255,0.4);
    height:100%;
    width:60%;
    margin:auto;
    overflow:hidden;
    border-radius:3px;
    box-shadow:0px 0px 6px 0px gray;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}
.imgContainer img{
    height:100%;
    transition:1s;

    position:absolute;
}
.grid2{
  display:grid;
  grid-template:1fr 1fr 1fr / 1fr 1fr;
  min-height:500px;
  width:90%;
  margin:auto;
  grid-gap:20px 10px;
  border:0px solid red;
  margin-bottom:50px;
}
.priceItem{
  margin:10px;
}
footer{
  height:50px;
  background:lightgray;
  box-shadow:inset 0px 5px 10px 0px rgba(0,0,0,0.2);
}

/*animations*/
@keyframes fadeIn{
    0%{opacity:0;}
    100%{opacity:1;}
}
/*RESPONSIVENESS*/
@media only screen and (max-width: 800px) {
    #logo{
        min-width:300px !important;
        height:200px;
    }
    .gridBlock{
        border:1px solid lightgray;
    }
    .grid1{
        grid-template:auto / 1fr;
        width:95%;
        margin-top:0px;
        grid-gap: 15px 20px;
    }
    .grid2{
        grid-template:auto / 1fr;
        width:95%;
        margin-top:0px;
        grid-gap: 15px 20px;
    }
    .mobileAdjust{
        grid-row:auto !important;
        grid-column: auto !important;
        min-height:333px;
    }
    #pricing{
        grid-row:0/1 !important;
        grid-column: auto !important;
    }

    /*pics*/
    .carousel{
        width:100%;
    }
    .block{
        width:33%;
    }
    .imgContainer{
        width:80%;
    }
    .mobileBlock{
        display:none;
    }

}
    </style>
</head>
<div id='logo'>
  <img src='images/logo.png' style='width:100%;'>
</div>
<div class='grid1'>
  <div class='gridBlock'>
    <h4>Store Hours</h4>
    <?php
     echo "<h5>";
     separate($outputContainer['Hours'][count($outputContainer['Hours'])-1][0]);
     echo "</h5>";
    ?>
    <!--
    <h5>

      Mon-Thurs: 7am - 7pm<br>
      Fri: 7am - 8pm<br>
      Sat-Sun: 6am - 5pm<br>
    </h5>
    -->
  </div>
  <div class='gridBlock' style='background:url("/images/storefront.jfif") center;background-size:100%;min-height:150px;'>

  </div>
  <style>
    .socialMediaContainer{
        height:75px;
        width:50%;
        border-top:0px solid red;
        position:absolute;
        bottom:0;
        left:25%;
    }
    .socialMediaContainer a{
        text-decoration:none;
        padding:5px;
        font-size:25px;
        color:gray;
    }
    .socialMediaContainer a:hover{
        opacity:0.5;
        transition:0.2s;
    }
    .flexCenter{
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .top{}
    .bottom{opacity:0;}

  </style>
  <div class='gridBlock mobileAdjust' style='grid-row:1/3;grid-column:3/3;'>
    <h4>Address:</h4>
    <h5>6301 Ditman St, Philadelphia PA 19135</h5>
    <br>
    <h4>Phone:</h4>
    <h5>215-331-8836</h5>
    <br>
    <h4>Email:</h4>
    <h5>Sportmasterbaitandtackle@gmail.com</h5>
    <div class='socialMediaContainer flexCenter'>
        <a href="https://www.facebook.com/sportmasterbait/" style='color:#3b5998' class="fa fa-facebook"></a>
        <a href="https://twitter.com/sportmasterbait?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor" style='color:#38A1F3' class="fa fa-twitter"></a>
        <a href="https://www.instagram.com/accounts/login/?next=/explore/locations/804816838/sportmaster-bait-and-tackle" class="fa fa-instagram"></a>
    </div>
  </div>
  <div class='gridBlock'>
    <h4>News & Updates</h4>
    <?php
     echo "<h5>";
     separate($outputContainer['News'][count($outputContainer['News'])-1][0]);
     //echo $outputContainer['News'][count($outputContainer['News'])-1][0];
     echo "</h5>";
    ?>
  </div>
  <div class='gridBlock'>
    <div id='googleMap' style='width:100%;height:100%;background:lightgray;min-height:150px;'></div>
  </div>
</div>

<div class='carousel' id='carousel' >
  <div class='block'>
      <div class='imgContainer'>
          <img class='bottom' src='' >
          <img class='top' src=''>
      </div>
  </div>
  <div class='block'>
      <div class='imgContainer'>
          <img class='bottom' src='' >
          <img class='top' src=''>
      </div>
  </div>
  <div class='block'>
      <div class='imgContainer'>
          <img class='bottom' src='' >
          <img class='top' src=''>
      </div>
  </div>
  <div class='block mobileBlock'>
      <div class='imgContainer'>
          <img class='bottom' src='' >
          <img class='top' src=''>
      </div>
  </div>
  <div class='block mobileBlock'>
      <div class='imgContainer'>
          <img class='bottom' src='' >
          <img class='top' src=''>
      </div>
  </div>
</div>
<script>
//picIndexVar
var picIndex = 1;

//current section. 1 = top, 0 = bottom
var picBool = 1;

//seconds for fade animation
var timingVar = 5;

//multiplier for delay
var multiplier = 1000;

//picFader code
function fadePic(){
    document.getElementById("img1").style.animation = 'fadeIn ' + timingVar +'s 0s infinite';
    document.getElementById("img1").src = "images/customers/" + picIndex + ".png";

    //document.getElementById("test").style.background='blue';
}
function fadeRow(){
    setInterval(function(){
        fadePic();
        picIndex++;
        if(picIndex>12){
            picIndex = 1;
        }
    }, timingVar*1000);
}
function fadeItem(){
    var tops = document.getElementsByClassName('top');
    var bots = document.getElementsByClassName('bottom');


    //document.getElementById('bool').innerHTML = picBool;
    //tops[0].style.opacity = 0;
    //bots[0].style.opacity = 1;

    /*
    setTimeout(function(){
        tops[0].src = '/images/customers/3.png';
        tops[0].style.opacity = 1;
        bots[0].style.opacity = 0;
    },2000);
    */
    if(picBool < 1){
        for(var i=0;i<tops.length;i++){
            tops[i].src="images/customers/" + picIndex + ".png";
            tops[i].style.opacity = 1;
            bots[i].style.opacity = 0;
            picIndex++;
            if(picIndex>12) picIndex=1;
        }
        picBool = 1;
    }else{
        for(var i=0;i<bots.length;i++){
            bots[i].src="images/customers/" + picIndex + ".png";
            bots[i].style.opacity = 1;
            tops[i].style.opacity = 0;
            picIndex++;
            if(picIndex>12) picIndex=1;
        }
        picBool = 0;
    }
}//end fxn fadeItem
fadeItem();
var picInterval = setInterval(fadeItem,7700);
/*
function fadeSequence(){
    //pic 1
    setTimeout(,0*multiplier);
    //pic 2
    setTimeout(,1*multiplier);
    //pic 3
    setTimeout(,2*multiplier);
    //pic 4
    setTimeout(,3*multiplier);
    //pic 5
    setTimeout(,4*multiplier);
}
*/
//inner fxn:
//1. changes specific pic according to current var --> resets var if it's over limit
//setTimeout(myFunction, 3000)
//picFader code --- END

//Need to have top and bottom pics that are being alternated.

</script>
<!--
<div class='picScroller'></div>
-->

<div class="grid2">
  <div class="gridBlock" id="test">
    <h4>Useful Links</h4>
    <h5><a href="https://www.fishandboat.com/Pages/default.aspx">PA Fish and
    Boat</a> <br> <a href="https://www.saltwatertides.com/">Tides</a><br></h5>
  </div>

  <div class="gridBlock" style="grid-column:1/3;grid-row:1/3;">
    <h4 style="display:inline-block">Helpful Info</h4>
    <div style="background:lightblue;float:right;width:400px;height:100%;"></div>
  </div>

  <div class="gridBlock" id="test">
    <h4>Useful Links</h4>
    <h5><a href="https://www.fishandboat.com/Pages/default.aspx">PA Fish and
    Boat</a> <br> <a href="https://www.saltwatertides.com/">Tides</a><br></h5>
  </div>

</div>

<div class='grid2'>
  <div class='gridBlock' id='test'>
    <h4>Useful Links</h4>
    <?php
     echo "<h5>";
     separate($outputContainer['Links'][count($outputContainer['Links'])-1][0]);
     //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
     echo "</h5>";
    ?>
    <!--
    <h5><a href='https://www.fishandboat.com/Pages/default.aspx'>PA Fish and Boat</a></h5>
    <h5><a href='https://www.saltwatertides.com/'>Tides</a></h5>
    -->
  </div>
  <div class='gridBlock'>
    <h4>Helpful Info</h4>
    <?php
     echo "<h5>";
     separate($outputContainer['HelpInfo'][count($outputContainer['HelpInfo'])-1][0]);
     //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
     echo "</h5>";
    ?>
  </div>
  <div class='gridBlock'>
    <h4>Partners</h4>
    <?php
     echo "<h5>";
     separate($outputContainer['Partners'][count($outputContainer['Partners'])-1][0]);
     //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
     echo "</h5>";
    ?>
    <!--
    <h5><a href='https://www.phila.gov/departments/philadelphia-parks-recreation/'>Philadelphia Parks & Rec</a></h5>
    <h5><a href='https://riverfrontnorth.org/'>Riverfront North</a></h5>
    <h5><a href='https://www.facebook.com/northeastjigco/'>NorthEast Jig Co</a></h5>
    -->
  </div>
  <div class='gridBlock ' id='pricing' style='grid-column:2/2;grid-row:1/4;'>
    <h4>Pricing</h4>
    <?php
     echo "<div class='priceItem'>";
     separate($outputContainer['Pricing'][count($outputContainer['Pricing'])-1][0]);
     //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
     echo "</div>";
    ?>
    <!--
    <div class='priceItem'>
      <u>Bloodworms:</u><br>
      Regular- $13.00/ dozen<br>
      Large- $17.00/dozen<br>
      Jumbo- $21.50/dozen<br>
    </div>
    <div class='priceItem'>
      <br><u>Nightcrawlers</u>- $3.25/dozen<br><br>
      Nitro Worms- $4.25/ dozen<br><br>
      Red Worms - $3.79/ 24 count<br><br>
      Meal Worms - $2.39/ 30 count, $6.99/ 100 count<br>
    </div>
    -->
  </div>
</div>
<!--
<footer></footer>
-->
</body>
</html>
