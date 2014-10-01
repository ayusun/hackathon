<?php
    if(isset($_GET['toplist'])) {
	    session_start();
	    $userid = $_SESSION['id'];
	    include("./connection.php");
		$con = connection :: getConnection();
	    $res = $con->query("select * from spotfixevents where isreported=0 and byuser=".$userid);
	    $outputArray = array();
	    while($row = $res->fetch_assoc()){
		    $outputArray[] = $row;
		}
		echo json_encode($outputArray);
    }
    if(isset($_POST['reportevent'])){
	    session_start();
	    print_r($_FILES);
	    if($_FILES['beforepic']['size'] > 0 && $_FILES['afterpic']['size'] > 0){
		    $userid     = $_SESSION['id'];
		    $username   = $_SESSION['name'];
		    $eventid    = $_POST['eventid'];
		    $comp_date  = $_POST['comp_date'];
		    $comp_time  = $_POST['comp_time'];
		    $comp_dt_tm = $comp_date. " " . $comp_time;
		    include("./connection.php");
            $con = connection :: getConnection();
		    $stmt = $con->prepare("update spotfixevents set closetime=?, isreported=1 where id=?");
		    $stmt->bind_param("si", $comp_dt_tm, $eventid);
		    $stmt->execute();
		    
		    $desc      = $_POST['desc'];
		    $eventid   = $_POST['eventid'];
		    $picloc    = $username . "_" . $eventid . time();
		    $oldpicloc = "upload/fix/old/" .  $picloc;
		    $newpicloc = "upload/fix/new/" .  $picloc;
		    
		    $stmt = $con->prepare("insert into spotfixreports values(?,?,?,?)");
		    $stmt->bind_param("isss", $eventid, $oldpicloc, $newpicloc, $desc);
		    $stmt->execute();
		    move_uploaded_file($_FILES['beforepic']['tmp_name'], $oldpicloc);
		    move_uploaded_file($_FILES['afterpic']['tmp_name'], $newpicloc);
	    }
	    header("Location:./");
	}
?>
