<?php
   
    include("./connection.php");
    $con = connection :: getConnection();
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $pass     = sha1(mysqli_real_escape_string($con,$_POST['passwd']));
    $res = $con->query("select * from User where username='$username' and passwd='$pass'");
    $count = $res->num_rows;
    if($count == 1){
	    session_start();
	    $row = $res->fetch_assoc();
	    $_SESSION['id'] = $row['id'];
	    $_SESSION['name'] = $row['Name'];
	}
	
	header("Location:./");
?>
