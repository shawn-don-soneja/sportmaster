<?php

//Database login file
include 'db_connect.php';

//Start Connection
$conn = OpenCon();

//prepare SQL statement to affect db
$mainArray = $_REQUEST['LocationNames'];
//$rowCount = $_POST['rowCount'];
$word = "word";
//$sql_In = "INSERT INTO `master`(`Content`, `Category`) VALUES ('".$first."','".$sec."')"; //why do we need to put extra quote in line 13, around variables? 

//tries using statement here 
if ($conn->query($sql_In) === TRUE) {
    echo "<b>Submitted</b><br>";
} else {
    echo "Error: " . $sql_In . "<br>" . $conn->error;
}


echo "<br>";
echo "<u>Output</u>:";
echo "<br>";
echo "<br>";


print($mainArray[0]);
foreach ($mainArray as $v) {
    print_r($v); //print all array element.
}
echo "<br>";
print($_POST['rowCount']);
print("___");

//header('Refresh: 3; /index.php');

CloseCon($conn);
?>
<br>
<!--
<a href='/index.php'><button>Home</button></a>
<a href='/contentControl/index.php'><button>Content Control</button></a>
-->
