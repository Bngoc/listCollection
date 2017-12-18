<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "labs";
$prefix = "";
$bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password);// or die("Opps some thing went wrong");
//mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");
if (mysqli_connect_errno()){
		echo "Connect failed: " . $mysql_database;
		exit();
	}
?>