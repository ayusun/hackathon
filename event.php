<?php
include("./connection.php");
$con = connection :: getConnection();
session_start();
$eventid = mysqli_real_escape_string($con,$_GET['id']);
$userid  = $_SESSION['id'];
$res = $con->query("select * from spotfixevents where id = " . $eventid);
$count = $res->num_rows;
if($count == 1){
    $row = $res->fetch_assoc();
    echo "<div id=cover><img style='display:block;margin-left:auto;margin-right:auto;max-height:50%;max-width:50%;'src=" . $row['photo'] . "></div>";
    echo "<div style='text-align:center;'>";
    echo "<div id=desc>". $row['description']."</div>";
    echo "<br>";
    echo "<div>Latitude : ". $row['latitude'] . ", Longitude : ". $row['longitude'] . "</div>";
    echo "<div> Address : " . $row['address'] . "</div>";
    $res1 = $con->query("select * from spotfixattendees where eventid=" . $eventid);
	$attendCount = $res1->num_rows;
	echo "<div>Number of attendees : $attendCount </div>"; 
    if($row['isreported'] == 1){
	    echo "<div> Status : Reported</div>";
	    $res_for_report = $con->query("select * from spotfixreports where eventid=".$eventid);
	    $row  = $res_for_report->fetch_assoc();
	    echo "<div><table style='margin-left:auto;margin-right:auto;'><tr><td>Before Pic</td></tr>";
	    echo "<tr><td><img src=" . $row['beforepic'] . "></td></tr>";
	    echo "<tr><td>After Pic</td></tr>";
	    echo "<tr><td><img src=" . $row['afterpic']  . "></td></tr>";
	    echo "</table></div>";
	    echo "<div>Description of the fix : " . $row['Description'] . "</div>"; 
	} else {
	    $res1 = $con->query("select * from spotfixattendees where userid = " . $userid . " and eventid=" . $eventid);
	    $count1 = $res1->num_rows;
	    if($count1 == 1){
		    echo "<div> Status : Joined</div>";
		} else {
		    echo "<div>Status : Available TO Join</div>";
		}
	}
	
	echo "</div>";

}
?>
