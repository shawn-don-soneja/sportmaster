<?php

//Database login file
include 'db_connect.php';

//Start Connection
$conn = OpenCon();

//prepare SQL statement to affect db
$first = $_REQUEST['content'];
$sec = $_REQUEST['category'];
$word = "word";
$sql_In = "INSERT INTO `master`(`Content`, `Category`) VALUES ('".$first."','".$sec."')"; //why do we need to put extra quote in line 13, around variables? 

//tries using statement here 
if ($conn->query($sql_In) === TRUE) {
    echo "<b>New record created successfully</b><br>";
} else {
    echo "Error: " . $sql_In . "<br>" . $conn->error;
}
echo "<u>Content</u>:";
echo $first;
echo "<br>";
echo "<u>Category</u>:";
echo $sec;

//header('Refresh: 3; /index.php');

CloseCon($conn);
?>
<br>
<a href='/index.php'><button>Home</button></a>
<a href='/contentControl/index.php'><button>Content Control</button></a>