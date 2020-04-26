<?php
session_start();

$_Session["MyNumber"] = 330;
//Database login file
include 'db_connect.php';
date_default_timezone_set('America/New_York');  
//Start Connection
$conn = OpenCon();

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "<b>Connection Status:</b> we good<br>";
}


//send post


if(isset($_POST['LocationNames'])){
    $date = date("Y-m-d h:i:sa");
    
  
    $sql = "UPDATE `updateMessage` SET `Message`='".$_POST["updateMessage"]."',`on/off`='".$_POST["on/off"]."',`date`='".$date."' WHERE 1";
    $result = $conn->query($sql);
    
    for($i=0;$i< count($_POST['LocationNames']) ;$i++){
   
    
    $tracker = $_POST['toggleInput'];
  
    $sql = "UPDATE `TimetableEntries` SET `LocationName`='".$_POST['LocationNames'][$i]."',`Address`='".$_POST['addresses'][$i]."',`ArrivalTime`='".$_POST['arrivalTimes'][$i]."',`Lat`='".$_POST['latitudes'][$i]."',`Longitude`='".$_POST['longitudes'][$i]."' WHERE `ID` = '".$_POST['IDs'][$i]."'";
    //Query output for updating timetables
    $result = $conn->query($sql);

    }

}//end isset if statement

if(isset($_POST['baitHours'])){
    //seven updates statements for each day of the week 
    $update_1 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][0]."' WHERE ID='0' ";
    $update_2 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][1]."' WHERE ID='1' ";
    $update_3 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][2]."' WHERE ID='2' ";
    $update_4 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][3]."' WHERE ID='3' ";
    $update_5 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][4]."' WHERE ID='4' ";
    $update_6 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][5]."' WHERE ID='5' ";
    $update_7 = "UPDATE `baitRunnersHours` SET `Hours`='".$_POST['baitHours'][6]."' WHERE ID='6' ";

    //executing each of the updates
    $result = $conn->query($update_1);
    $result = $conn->query($update_2);
    $result = $conn->query($update_3);
    $result = $conn->query($update_4);
    $result = $conn->query($update_5);
    $result = $conn->query($update_6);
    $result = $conn->query($update_7);
    
    print("<script> 
        console.log(".count($_POST['baitHours']).");
        console.log('".$_POST['baitHours'][0]."');
    </script>");
}


//Query statement 
$sql = "SELECT `LocationName`,`Address`,`ArrivalTime`,`Lat`,`Longitude`,`ID` FROM `TimetableEntries`";
$sqlMsg = "SELECT * FROM `updateMessage`";

//Query output
$result = $conn->query($sql);
$resultMsg = $conn->query($sqlMsg);

$outputContainer = array();
$outputContainer['rowID'] = [];
$outputContainer['Locations'] = [];
$outputContainer['Addresses'] = [];
$outputContainer['ArrivalTime'] = [];
$outputContainer['Lat'] = [];
$outputContainer['Longitude'] = [];
$outputContainer['message'] = [];
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

$rowCount;
//Iterate over your output if there's data
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        array_push($outputContainer['rowID'],$row['ID']);   
        array_push($outputContainer['Locations'],$row['LocationName']);   
        array_push($outputContainer['Addresses'],$row['Address']);   
        array_push($outputContainer['ArrivalTime'],$row['ArrivalTime']); 
        array_push($outputContainer['Lat'],$row['Lat']); 
        array_push($outputContainer['Longitude'],$row['Longitude']); 
    }
    
    
    $_POST['rowCount'] = count($outputContainer['Locations']);
} else {
    echo "0 results";
}

//retrieve message


if ($resultMsg->num_rows > 0) {

    while($row = $resultMsg->fetch_assoc()) {

        array_push($outputContainer['message'],$row['Message']);        
        
    }
    
    
    
} 

//=========  Hours  CODE  ==========
$hoursInfo = array();
$hoursInfo['hours'] = array();
$hoursInfo['day'] = array();
$hoursInfo['id'] = array();

$hoursPull = "SELECT * FROM `baitRunnersHours`  ";

//Query output
$resultHours = $conn->query($hoursPull);

if ($resultHours->num_rows > 0) {

    while($row = $resultHours->fetch_assoc()) {
        array_push($hoursInfo['hours'],$row['Hours']);
        array_push($hoursInfo['day'],$row['Day']);
        array_push($hoursInfo['id'],$row['ID']);
        
    }
    
}



//Close that connection 
CloseCon($conn);

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<body onload="updateToggleButton('dog')">
    
<form action="https://sportmasterbaitandtackle.com/baitrunners/contentControl/index.php?" method="post">



<!-- hours labels -->
<br>
<b>
<div class='text mobileDisappear' style='width:33px;'>Row</div><div class='text'>Day</div><div class='text'>Hours</div>
</b>
<br>

<?php
    for($i=0;$i<count($hoursInfo['hours']);$i++){
        
        print("<div class='text' style='width:33px;'>".$hoursInfo['id'][$i]."</div>");
        //print("<input name='baitDays[]' ".$hoursInfo['day'][$i]."' value='".$hoursInfo['day'][$i]."'/>");
        print("<input name='baitDays[]'  value='".$hoursInfo['day'][$i]."'/>");
        print("<input name='baitHours[]' value='".$hoursInfo['hours'][$i]."'/>");
        
        
        print("<br>");
        print("<script>console.log(".count($hoursInfo).")</script>");
        /*
        
        
        */
        
    }
?>

       

<!--location labels-->
<br>
<b>
<div class='text mobileDisappear' style='width:33px;'>Row</div><div class='text'>Location Name</div><div class='text'>Address</div><div class='text' style=''>Arrival Time</div><div class='text'>Lat</div><div class='text'>Long</div>
</b>
<br>

<?php
    for($i=0;$i<count($outputContainer['Locations']);$i++){
        //print();
        //print("<input id='prevlocal".$i."' value='".$outputContainer['Locations'][$i]."' hidden/>");
            
            
        print("<div class='text' style='width:33px;'>".$outputContainer['rowID'][$i]."</div>");
        //print()
        print("<input name='LocationNames[]' id='local".$outputContainer['Locations'][$i]."' value='".$outputContainer['Locations'][$i]."'/>");
        //print("<input name='IDs[]' id='localP".$i."' value='".$outputContainer['rowID'][$i]."' hidden/>");
        print("<input name='IDs[]' value='".$outputContainer['rowID'][$i]."' hidden/>");
        print("&nbsp;");
        print("<input id='' value='".$outputContainer['Addresses'][$i]."' name='addresses[]'/>");
        print("<input id='arrival".$i."' value='".$outputContainer['ArrivalTime'][$i]."' name='arrivalTimes[]'/>");
        print("&nbsp;");
        print("<input id='lat".$i."' value='".$outputContainer['Lat'][$i]."' name='latitudes[]'/>");
        print("&nbsp;");
        print("<input id='long".$i."' value='".$outputContainer['Longitude'][$i]."' name='longitudes[]'/>");
        print("<br>");
        /*
        
        
        */
        
    }
?>


<!-- inputs for schedule-->

<!-- input of update message -->


<div style='margin-top:20px;' class='mobileLarge'><b>Update Message</b></div>
<textarea rows='4' cols='50' name='updateMessage' placeholder=''>
<?php print($outputContainer['message'][0])?>
</textarea>
<br>
<select id="on/off" name="on/off" class='mobileLarge'>
  <option value="true">On</option>
  <option value="false">Off</option>
</select>
<!-- end update message -->

<!-- tracker input -->
<br>
<div style='margin-top:20px;' onclick="updateToggleButton('recludo12')" id ="trackerButton" class='trackerToggle mobileLarge'>Tracker Toggle</b></div>
<input value="" id="toggleInput" name='toggleInput' hidden/>
<input value="" id="bradyLat" name="bradyLat" hidden/>
<input value="" id="bradyLong" name="bradyLong" hidden/>

<script>

    postAreaData = (arg,arg2) => {
        
      $.post("https://sportmasterbaitandtackle.com/baitrunners/contentControl/updatLocation.php",
    {
      bradyLat: arg,
      bradyLong: arg2,
      toggleInput:true
    },
    function(result){
      console.log("area set");
      
     var trackerL = "true";
   sessionStorage.setItem("MyId", 'true');
    }
   
    );
           
        
 
    
    
}
    



    var pos;
    var datVar;
    
    
    //load Brads position
     
     var lt;
     var lg;
    function loadPosition(login){
       
          
              if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              
            
            
                var bradLat = document.getElementById('bradyLat');
            var bradLong = document.getElementById('bradyLong');
            bradLat.value = position.coords.latitude;
            bradLong.value = position.coords.longitude;
            
            //myTimed = setInterval(postAreaData(position.coords.latitude,position.coords.longitude), 3000);
            lt =  position.coords.latitude;
            lg = position.coords.longitude;
            postAreaData(lt,lg);
            
            
          });
          }
              
    if(login == ' '){
              var bradLat = document.getElementById('bradyLat');
            var bradLong = document.getElementById('bradyLong');
            bradLat.value = " ";
            bradLong.value = " ";
            postAreaData(" "," ");
           
          }
      
          
          
      }
      




    var toggleStatus;
    
   var myTimed;
    function updateToggleButton(login){
        var button = document.getElementById('trackerButton');
        var toggleInput = document.getElementById('toggleInput');
        
        if (toggleInput.value == ""){
            toggleInput.value = 'false';
        }
        
        
        var value = sessionStorage.getItem("MyId");
        if(value)
        console.log('tracker ' + value);
        if(toggleInput.value == 'false' && login =='recludo12'|| toggleInput.value == 'false' && value == 'true' ) {
            button.style.backgroundColor = 'green';
            button.innerHTML = 'You are Tracking. <b>Click to Untrack</b>';
            toggleInput.value = 'true';
            myTimed = setInterval(loadPosition,1000);
            
            
            
        }else if(toggleInput.value == 'true'  || toggleInput.value == 'true' && login =='Dog' || value == 'true' && login =='Dog'){
            button.style.backgroundColor = 'red';
            button.innerHTML = 'You are not Tracking. <b>Click to Track</b>';
            toggleInput.value = 'false';
            
            clearInterval(myTimed);
            var trackerL = "false";
            sessionStorage.setItem("MyId", 'false');
        }
    }
    function toggleEdit(){
        document.getElementById("editInputs").classList.toggle('closed');
    }
    
  
</script>
<style>
@media screen and (max-width:1000px){
    input{width:165px;font-size:20px;height:70px;}
    .mobileDisappear{opacity:0;}
    .mobileLarge{font-size:40px;margin-top:60px !important;}
    textarea{height:200px;width:100%;margin:auto;font-size:40px;}
    .text{font-size:40px;}
    #mainSub{width:95%;height:100px;border-radius:0 !important;font-size:40px;margin-top:50px;}
}
button:hover{cursor:pointer;}
.closed{display:none;}
.text{width:165px;display:inline-block;border:1px solid red;margin-right:2px;}
.trackerToggle{
    padding:5px;
    border-radius:3px;
    display:inline-block;
    cursor:pointer;
    
}
#trackerButton{
    background-color:red;
}
input{margin:0;}</style>

<br><br>
<!-- end tracker input-->
<style>#mainSub{padding:5px;background:lightblue;transition:0.2s;}#mainSub:hover{opacity:0.5;}</style>
<input type="submit" value="Submit" id='mainSub' style='cursor:pointer;' class=''>

       
   </form> 
    
    
</body>