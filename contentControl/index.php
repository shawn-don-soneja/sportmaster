<?php

//Database login file
include 'db_connect.php';

//Start Connection
$conn = OpenCon();

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "<b>Connection Status:</b> we good<br>";
}

//Query statement 
$sql = "SELECT `Content`,`Category`,`Date` FROM `master`";

//Query output
$result = $conn->query($sql);

$outputContainer = array();
$outputContainer['Hours'] = [];
$outputContainer['Pricing'] = [[]];
$outputContainer['Pictures'] = [];
$outputContainer['News'] = [];
//new fields
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




//Close that connection 
CloseCon($conn);

?>

<style>
    .preview{
        display:grid;
        grid-template:1fr 1fr / 1fr 1fr;
    }
    .preview .gridBlock{
        height:100%;
        width:100%;
        background:linear-gradient(25deg, white 40%, lightgray);
    }
    .center{
        text-align:center;
    }
    .preview h2{
        margin:0;
        padding:0;
    }
    .preview
</style>
<div style='position:absolute;top:0;right:0;width:500px;text-align:center;padding:5px;'>Website Preview:</div>
<div class='preview' style='height:450px;width:500px;border:2px solid lightblue;position:absolute;top:25;right:0;overflow-y:scroll;'>
    <div class='gridBlock'>
        <h2 class='center'>News</h2>
        <?php
        //echo $outputContainer['News'][count($outputContainer['News'])-1][0];
        separate($outputContainer['News'][count($outputContainer['News'])-1][0]);
        ?>
    </div>
    <div class='gridBlock'>
        <h2 class='center'>Pricing</h2>
        <?php
        //echo $outputContainer['Pricing'][count($outputContainer['Pricing'])-1][0];
        separate($outputContainer['Pricing'][count($outputContainer['Pricing'])-1][0]);
        ?>
    </div>
    <div class='gridBlock'>
        <h2 class='center'>Hours</h2>
        <?php
        //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
        separate($outputContainer['Hours'][count($outputContainer['Hours'])-1][0]);
        ?>
    </div>
    <div class='gridBlock'>
        <h2 class='center'>Pictures</h2>
        <?php
        echo $outputContainer['Pictures'][count($outputContainer['Pictures'])-1][0];
        ?>
    </div>
</div>
<!-- for Useful links, partners, and Helpful Info -->
<div class='preview' style='height:400px;width:500px;border:2px solid blue;position:absolute;top:480;right:0;overflow-x:scroll;'>
    <div class='gridBlock'>
        <h2 class='center'>Helpful Info</h2>
        <?php
        //echo $outputContainer['News'][count($outputContainer['News'])-1][0];
        separate($outputContainer['HelpInfo'][count($outputContainer['HelpInfo'])-1][0]);
        ?>
    </div>
    <div class='gridBlock'>
        <h2 class='center'>Useful Links</h2>
        <?php
        //echo $outputContainer['Pricing'][count($outputContainer['Pricing'])-1][0];
        separate($outputContainer['Links'][count($outputContainer['Links'])-1][0]);
        ?>
    </div>
    <div class='gridBlock'>
        <h2 class='center'>Partners</h2>
        <?php
        //echo $outputContainer['Hours'][count($outputContainer['Hours'])-1][0];
        separate($outputContainer['Partners'][count($outputContainer['Partners'])-1][0]);
        ?>
    </div>
</div>
<div style='position:absolute;top:885;right:0;height:auto;width:500px;border:1px solid red;'>
    <img src='/images/help.png'>
    <h2 style='text-align:center;'>Having trouble uploading?</h2>
    <p>Make sure there's no single quotes in your upload statement, like this --> ' <br>Example: 'word' , or href='link'<br>
    <br>If there are any, just replace them with double quotes --> "<br>
    Example: "word" , or href="link"
    </p>
</div>


<!-- actual inputs --> 
<div style='width:550px;height:165px;border:1px solid green;'>
    <form action="/contentControl/sendInfo.php">
      Content: <textarea style='' rows='4' cols='70' name="content" wrap='hard' required></textarea><br>
      Category: 
      <!--<input type="text" name="category"><br>-->
      <select name='category'>
          <option value="Hours">Hours</option>
          <option value="News">News</option>
          <option value="Pricing">Pricing</option>
          <option value="Pictures">Pictures</option>
          <option value="HelpInfo">Help Info</option>
          <option value="Links">Useful Links</option>
          <option value="Partners">Partners</option>
        </select>
      <br><br>
      <input type="submit" value="Submit" style='width:100%;cursor:pointer;'>
    </form>
    
</div>
<style>
    .record{
        height:auto;
        min-height:20px;
        border-bottom:3px solid gray;
        position:relative;
        /*display flex works magic. Need to learn more*/
        display:flex;
    }
    .record .content{
        font-size:12px;
        width:55%;
        border-right:1px solid red;
        line-height:1.4;
        padding:5px;
        display:inline-block;
    }
    .record .category{
        font-size:12px;
        width:13%;
        border-right:1px solid blue;
        line-height:1.4;
        padding:5px;
        display:inline-block;
        height:auto;
    }
    .record .time{
        position:relative;
        height:auto;
        font-size:12px;
        width:22%;
        border-right:1px solid blue;
        line-height:1.4;
        padding:5px;
        display:inline-block;
    }
</style>
<br><u>All Content:</u><br>
<br>Hours
<!-- hours container -->
<div style='width:550px;height:150px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        
        for($a=0;$a<count($outputContainer['Hours']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['Hours'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("Hours");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['Hours'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        
        ?>
    
</div>
<br>News
<!-- News container -->
<div style='width:550px;height:150px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        for($a=0;$a<count($outputContainer['News']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['News'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("News");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['News'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        ?>
</div>
<br>Pricing
<!-- Pricing container -->
<div style='width:550px;height:150px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        for($a=0;$a<count($outputContainer['Pricing']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['Pricing'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("Pricing");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['Pricing'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        ?>
</div>
<br>Helpful Info
<!-- HelpInfo container -->
<div style='width:550px;height:100px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        for($a=0;$a<count($outputContainer['HelpInfo']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['HelpInfo'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("Helpful Info");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['HelpInfo'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        ?>
</div>
<br>Useful Links
<!-- Links container -->
<div style='width:550px;height:100px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        for($a=0;$a<count($outputContainer['Links']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['Links'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("Useful Link");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['Links'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        ?>
</div>
<br>Partners
<!-- Partners container -->
<div style='width:550px;height:100px;overflow:scroll;border:1px solid blue;'>
    <div class='record'>
        <div class='content'>
            Content
        </div>
        <div class='category'>
            Category
        </div>
        <div class='time'>
            Date
        </div>
    </div>
        <?php
        for($a=0;$a<count($outputContainer['Partners']);$a++){
            print("<div class='record'>");
                print("<div class='content'>");
                print($outputContainer['Partners'][$a][0]);
                print("</div>");
                print("<div class='category'>");
                print("Partners");
                print("</div>");
                print("<div class='time'>");
                print($outputContainer['Partners'][$a][1]);
                print("</div>");
            print("</div>");//end record
        }
        ?>
</div>

