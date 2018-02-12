<!DOCTYPE html>
<html>
<head>
	<?php include("navbar.html"); ?>
</head>
<body>
	 
	<table id="table" align="center">
		<tr>
			<th colspan="7">List of Paid Participants</th>
		</tr>
		<tr class="header">
			<td onclick="sortTable(0);" >Event Id</td>
			<td onclick="sortTable(1);">First Name</td>
			<td onclick="sortTable(2);">Middle Name</td>
			<td onclick="sortTable(3);">Last Name</td>
			<td onclick="sortTable(4);">Contact Number</td>
			<td onclick="sortTable(5);" >Date of Payment</td>
			<td>Status</td>
			
		</tr>
		<?php
		include("connect.php");
		if(isset($_GET['search'])){
			$search = $_GET['search'];
			#$select = mysqli_query($con, "SELECT * FROM participants WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR contact_number LIKE '%$search%' OR student_number LIKE '%$search%' OR gender LIKE '%$search%' OR section LIKE '%$search%'");
		} else {
			#$select = mysqli_query($con, "SELECT participants.event_id, participants.first_name, participants.middle_name, participants.last_name, participants.student_number, participants.contact_number, participants.mode_of_payment, payment.cost FROM participants INNER JOIN payment ON participants.event_id=payment.event_id WHERE participants.event_id != (SELECT DISTINCT(`event_id`) FROM `payments`) OR cost < 350 ");
		    #$select = mysqli_query($con, "SELECT participants.event_id, participants.first_name, participants.middle_name, participants.last_name, participants.student_number, participants.contact_number, participants.mode_of_payment FROM participants WHERE participants.event_id NOT IN (SELECT DISTINCT(`event_id`) FROM `payment`)");
			$select = mysqli_query($con, "SELECT participants.event_id, participants.first_name, participants.middle_name, participants.last_name, participants.contact_number, payment.date_of_payment FROM participants INNER JOIN payment ON participants.event_id=payment.event_id");
		}
		if(mysqli_num_rows($select) > 0){
			while ($row = mysqli_fetch_assoc($select)){
				$status = "Fully paid";
				
				echo "<form method='POST' action='transaction.php'>
					<tr>
					<td>".$row['event_id']."</td>
					<td>".$row['first_name']."</td>
					<td>".$row['middle_name']."</td>
					<td>".$row['last_name']."</td>
					<td>".$row['contact_number']."</td>
					<td>".$row['date_of_payment']."</td>
					<td>".$status."</td>
					</tr>
					</form>
					";
			}
		}
	    ?>
	</table>
</body>
</html>