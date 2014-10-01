<?php
function distance($lat1, $lon1, $lat2, $lon2, $info) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $obj = array();
  $obj['distance'] = $miles;
  $obj['info']     = $info;
  return $obj;
}
function comp($a, $b){
    return $a['distance'] - $b['distance'];
}
if(isset($_GET['toplist'])){
	session_start();
	$userid  = $_SESSION['id'];
    $homelat = $_GET['lat'];
    $homelon = $_GET['lon'];
    include("./connection.php");
    $con = connection :: getConnection();
    $res = $con->query("select * from spotfixevents where id NOT IN(select eventid from spotfixattendees where userid=" . $userid . ")");
    while($row = $res->fetch_assoc()){
	    $distArray[] = distance($homelat, $homelon, $row['latitude'], $row['longitude'], $row);
	}
	usort($distArray, "comp");
	$outputArray = array();
	$i = 0;
	foreach($distArray as $val){
	    if($i < 5){
		    $outputArray[] = $val;
		}
		$i++;
	}
	echo json_encode($outputArray);
}
if(isset($_GET['join'])) {
	session_start();
	$eventid = $_GET['id'];
	$userid  = $_SESSION['id'];
	include("./connection.php");
    $con = connection :: getConnection();
	$stmt = $con->prepare("insert into spotfixattendees values(NULL,?,?)");
	$stmt->bind_param("ii", $eventid, $userid);
	$stmt->execute();
	$lastid = $con->insert_id;
	if($lastid > 0){
	    echo 1;
	} else {
	    echo 0;
	}
    
}

?>
