<?php
include 'db_connect.php';
date_default_timezone_set('America/New_York');  
//Start Connection
$conn = OpenCon();
//query for updating his current location
    //check if he has toggle location 
    print_r($_POST);
    if($_POST["bradyLat"] >0 or $_POST["bradyLat"] <0){
        $today = date("F j, Y, g:i a"); 
    
    print("eyy");
    $sql = "INSERT INTO `updatedLocation`(`Lat`, `Lng`, `Time`) VALUES (".$_POST["bradyLat"].",".$_POST["bradyLong"].",'".$today."')";
    
    //Query output
    $result = $conn->query($sql);
    if($result == 1){
         
       
        
    }
    
    
    CloseCon($conn);
    }
    ?>