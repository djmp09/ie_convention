<?php
	include("connect.php");
	if(isset($_POST['pay'])){
		$event_id = $_POST['event_id'];
		$mode = $_POST['mode'];
		$cost = 0;
		if($mode == "half"){
			$cost = 175;
		} else {
			$cost = 350;
		}
		$sql = "UPDATE payment SET cost = '$cost' WHERE event_id = '$event_id'";
		$update = mysqli_query($con, $sql);
		if($update){
			$sql = "UPDATE participants SET mode_of_payment = 'full' WHERE event_id = '$event_id'";
			$$update = mysqli_query($con, $sql);
			if($update){
				echo "
					<script>
						alert('Another one has paid to join the FORCE!');
					</script>
				";
			}
		} else {
			echo "ERROR: ". mysqli_error($con);
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
	<nav class="navbar navbar-inverse navbar-custom" style="color:black;">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a href="index.php" class="navbar-brand">ADMIN</a>
	    </div>
	    <ul class="nav navbar-nav">
	      <li><a href="add.php">ADD</a></li>
	      <li><a href="list.php">LIST</a></li>
	      <li><a href="transaction.php">TRANSACTIONS</a></li>
	    </ul>
	    <form class="navbar-form navbar-left" action="list.php" method="GET">
	      <div class="form-group">
	        <input type="text" class="form-control" name="search" placeholder="Search">
	      </div>
	      	<button type="submit" class="btn btn-default">Search</button>
	    </form>
	  </div>
	</nav>
	<table id="table" align="center">
		<tr>
			<th colspan="13">List of Participants</th>
		</tr>
		<tr class="header">
			<td onclick="sortTable(0);">Event Id</td>
			<td onclick="sortTable(1);">Student Number</td>
			<td onclick="sortTable(2);">First Name</td>
			<td onclick="sortTable(3);">Middle Name</td>
			<td onclick="sortTable(4);">Last Name</td>
			<td onclick="sortTable(7);">Contact Number</td>
			<td onclick="sortTable(8);">Mode of Payment</td>
			<td>Balance</td>
			<td>Status</td>
			<td>Action</td>
		</tr>
		<?php
		if(isset($_GET['search'])){
			$search = $_GET['search'];
			$select = mysqli_query($con, "SELECT * FROM participants WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR contact_number LIKE '%$search%' OR student_number LIKE '%$search%' OR gender LIKE '%$search%' OR section LIKE '%$search%'");
		} else {
			$select = mysqli_query($con, "SELECT participants.event_id, participants.first_name, participants.middle_name, participants.last_name, participants.student_number, participants.contact_number, participants.mode_of_payment, payment.cost FROM participants INNER JOIN payment ON participants.event_id=payment.event_id WHERE cost < 350 ");
		}
		if(mysqli_num_rows($select) > 0){
			while ($row = mysqli_fetch_assoc($select)){
				$status = "";
				if($row['cost'] < 350){
					$status = "Not yet fully paid";
				}
				echo "<form method='POST' action='transaction.php'>
					<tr>
					<td>".$row['event_id']."</td>
					<td>".$row['student_number']."</td>
					<td>".$row['first_name']."</td>
					<td>".$row['middle_name']."</td>
					<td>".$row['last_name']."</td>
					<td>".$row['contact_number']."</td>
					<td>".$row['mode_of_payment']."</td>
					<td>".(350-$row['cost'])."</td>
					<td>".$status."</td>

					<td>
						<input type='hidden' name='event_id' value='".$row['event_id']."'>
						<input type='hidden' name='mode' value='".$row['mode_of_payment']."'>
						<input type='submit' name='pay' value='Pay'>
					</td>
					</tr>
					</form>
					";
			}
		}
	?>
	</table>
</body>
</html>