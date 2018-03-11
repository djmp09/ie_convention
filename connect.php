<?php
	$con = mysqli_connect("localhost","root","raniel1206","ie_convention");
	if(!$con){
		die("Connection failed: " . $con->connect_error);
	}
?>