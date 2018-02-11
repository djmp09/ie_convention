<?php
	include("connect.php");
	if(isset($_POST["submit"]) && !isset($_GET['event_id'])){
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$mobno = $_POST['mobno'];
		$gen = $_POST['gen'];
		$stuno = $_POST['stuno'];
		$secyr = $_POST['secyr'];
		$mode = $_POST['mode'];
		$cost = 0.00;
		if($mode == "half"){
			$cost = 175;
		} else {
			$cost = 0;
		}
		$stunum = mysqli_query($con, "SELECT COUNT(*) AS total FROM participants");
		$data = $stunum->fetch_assoc();
		if($data['total'] == 0){
			$num = 1;
		} else {
			$select = mysqli_query($con, "SELECT MAX(ID) AS last FROM participants");
			$row = mysqli_fetch_assoc($select);
			$num = $row['last'] + 1;
		}
		$format = sprintf('%05d',$num);
		$final = date("Y")."-".$format;

		$sql = "INSERT INTO participants (event_id, first_name, middle_name, last_name, contact_number, gender, student_number, section, mode_of_payment) VALUES ('$final', '$fname', '$mname', '$lname', '$mobno', '$gen', '$stuno', '$secyr', '$mode')";
		if(mysqli_query($con, $sql)){
			$sql = "INSERT INTO payment (event_id, date_of_payment, cost) VALUES ('$final', '".date('Y-m-d H:i:s')."', '$cost')";
			if(mysqli_query($con, $sql)){
				echo "
					<script>
						alert('Another one joined the FORCE!');
					</script>
				";
			}
		} else {
			echo mysqli_error($con);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>IE CONVENTION</title>
	<link href="css/bootstrap.css" rel="stylesheet" />
	<link href="css/bootstrap-theme.css" rel="stylesheet" />
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="design.css">
</head>
<body>
	<?php include("navbar.html");
		$fname = "";
		$mname = "";
		$lname = "";
		$contact = "";
		$gen = "";
		$stuno = "";
		$sec = "";
		$mode = "";
		if(isset($_GET['event_id'])){
			$event_id = $_GET['event_id'];
			$select = mysqli_query($con, "SELECT * FROM participants WHERE event_id='$event_id'");
			if(mysqli_num_rows($select) > 0){
				while ($row = mysqli_fetch_assoc($select)){
					$fname = $row['first_name'];
					$mname = $row['middle_name'];
					$lname = $row['last_name'];
					$contact = $row['contact_number'];
					$gen = $row['gender'];
					$stuno = $row['student_number'];
					$sec = $row['section'];
					$mode = $row['mode_of_payment'];
				}
			}
		}
	?>
	<table align="center">
		<form action="add.php" method="POST">
			<tr>
				<td><input type="text" placeholder="First Name" name="fname" maxlength="20" pattern="[a-zA-z\s]+" title="Letters only" required="true" value=<?php echo'"'; if(isset($fname)){echo $fname;} echo '"';?>></td>
				<td><input type="text" placeholder="Middle Name" name="mname" maxlength="20" pattern="[a-zA-z\s]+" title="Letters only" required="true" value=<?php echo'"'; if(isset($mname)){echo $mname;}echo '"';?>></td>
				<td><input type="text" placeholder="Last Name" name="lname" maxlength="20" pattern="[a-zA-z\s]+" title="Letters only" required="true" value=<?php echo'"'; if(isset($lname)){echo $lname;}echo '"';?>></td>
			</tr>
			<tr>
				<td><input type="text" name="mobno" maxlength="11" pattern="09[0-9]{9}" title="09xxxxxxxxx" placeholder="Contact Number" required="true" value=<?php echo'"'; if(isset($contact)){echo $contact;}echo '"';?>></td>
				<td><input type="radio" name="gen" value="M" <?php if(isset($gen)){echo ($gen == "M")? "checked": "";} ?>> Male</td>
				<td><input type="radio" name="gen" value="F"' <?php if(isset($gen)){echo ($gen == "F")? "checked": "";} ?>> Female</td>
			</tr>
			<tr>
				<td><input type="text" placeholder="Student Number" name="stuno" required="true" value=<?php echo'"'; if(isset($stuno)){echo $stuno;}echo '"';?>></td>
				<td><input type="text" placeholder="Year and Section" name="secyr" required="true" value=<?php echo'"'; if(isset($sec)){echo $sec;}echo '"';?>></td>
			</tr>
			<tr>
				<td><input type="radio" name="mode" checked="true" value="full" <?php if(isset($mode)){echo ($mode == "full")? "checked": "";} ?>>Full</td>
				<td><input type="radio" name="mode" value="half" <?php if(isset($mode)){echo ($mode == "half")? "checked": "";} ?>>Half</td>
			</tr>
			<tr>
				<td colspan="3"><input type="submit" name="submit"></td>
			</tr>
		</form>
	</table>
</body>
</html>