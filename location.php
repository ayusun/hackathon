<?php
    session_start();
    $userid = $_SESSION['id'];
    include("./connection.php");
    $con = connection :: getConnection();
    $res = $con->query("select * from spotfixevents where id IN(select eventid from spotfixattendees where userid=" . $userid . ")");
    $outputArray = array();
    while($row = $res->fetch_assoc()){
	    $loc = array();
	    $loc['id']        = $row['id'];
	    $loc['latitude']  = $row['latitude'];
	    $loc['longitude'] = $row['longitude'];
	    $outputArray[] = $loc;
	}
	echo json_encode($outputArray);
?>
