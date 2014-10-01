<?php
session_start();
print_r($_POST);
$userid   = $_SESSION['id'];
$username = $_SESSION['name'];
$planDesc = $_POST['txt_desc'];
$planadd  = $_POST['txt_add'];
$dd       = $_POST['dd'];
$mm       = $_POST['mm'];
$yy       = $_POST['yy'];
$hh       = $_POST['hh'];
$min      = $_POST['min'];
$lati     = $_POST['latitude'];
$longi    = $_POST['longitude'];
$imageloc = $_FILES['image']['tmp_name'];
$newloc   = "upload/plan/". $username."-". time();
$dateevent = $yy . "-" . $mm . "-" . $dd ." ". $hh . ":" . $min .":" . ":00";

include("./connection.php");
$con = connection :: getConnection();
$stmt = $con->prepare("insert into spotfixevents values (NULL,?,?,NULL,?,?,?,?,NULL,0)") or die('cant prepare');
$con->error;
$stmt->bind_param("ssddsi", $dateevent, $planDesc, $lati, $longi, $planadd, $userid) or die ('cant bind');
$stmt->execute();

$lastid = $con->insert_id;
$stmt = $con->prepare("update spotfixevents set photo=? where id=?");
if($lastid > 0) {
	if($_FILES['image']['size'] > 0) {
        move_uploaded_file($imageloc, $newloc);
        $stmt->bind_param("si", $newloc, $lastid);
        $stmt->execute();
	}
}
$stmt = $con->prepare("insert into spotfixattendees values(NULL,?,?)");
$stmt->bind_param("ii", $lastid, $userid);
$stmt->execute();
header("Location:./");
?>
