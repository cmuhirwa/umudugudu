<?php  
error_reporting(E_ALL);
$db = new mysqli("localhost", "root", "" , "umudugudu");
	
	if($db->connect_errno){
		die('Sorry we have some problem with the Database!');
	}             
?>

