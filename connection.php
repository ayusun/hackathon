<?php
class connection{
    static $host = "localhost";
    static $user = "root";
    static $pass = "toor";
    static $db   = "spotfix";
    public static function getConnection(){
	    $con = mysqli_connect(self::$host, self::$user, self::$pass, self::$db);
	    return $con;
	} 
}
?>
