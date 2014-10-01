<?php
    session_start();
    $userid = $_SESSION['id'];
?>
<div>Name : <?=$_SESSION['name']?></div>
<?php
   include("./connection.php");
    $con = connection :: getConnection();
    $res = $con->query("select * from spotfixevents where byuser=".$userid);
    echo "<div>Events Planned :". $res->num_rows . "</div>";
    $res = $con->query("select * from spotfixattendees where userid=".$userid);
    echo "<div>Joined in :". $res->num_rows . " events </div>";
    $res  = $con->query('SELECT IFNULL(TIME_FORMAT(SEC_TO_TIME(sum(TIME_TO_SEC(TIMEDIFF( `closetime`, `date`)))), "%k:%i"),0) AS diff FROM `spotfixevents`, spotfixattendees WHERE spotfixattendees.eventid = spotfixevents.id and spotfixevents.isreported =1 and spotfixattendees.userid='.$userid);
    $row  = $res->fetch_assoc();
    $diff = $row['diff'];
    echo "<div> Total Hours Volunteered : " . $diff . " </div>";
?>
