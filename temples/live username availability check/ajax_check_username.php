<?php
include('database_connection.php');
//Include The Database Connection File 

if(isset($_POST['username'])){//If a username has been submitted 
	$username = mysqli_real_escape_string($bd,$_POST['username']);//Some clean up :)

	$check_for_username = $bd ->query("SELECT userid FROM member WHERE username='$username'");
//Query to check if username is available or not 

	$record =$check_for_username->num_rows;
	if($record >0 ){
		echo '1';//If there is a  record match in the Database - Not Available
	}
	else{
		echo '0';//No Record Found - Username is available 
	}
}

?>