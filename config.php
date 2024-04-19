<?php
$server="localhost";
$user="root";
$pass="";
$dbname="hrs_db";
//connection process
$conn= new mysqli($server,$user,$pass,$dbname);
if($conn->connect_error){
	die(connect_error);
}
?>