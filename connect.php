<?php
	$con = mysqli_connect("localhost","root","","ie_convention");
	if(!$con){
		die("Connection failed: " . $con->connect_error);
	}
?>