<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "u170253483_shawn";
 $dbpass = "orbis_wd";
 $db = "u170253483_sport";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
 
?>