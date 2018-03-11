<!DOCTYPE html>
<html>
<head>
	<?php include("navbar.html"); ?>
	<style>
		.header td:hover {
			cursor:pointer;
		}
	</style>
</head>
<body>
	<table id="table" align="center">
		<tr>
			<th colspan="13">List of Absent Participants (<?php echo date("Y/m/d"); ?>)</th>
		</tr>
		<tr class="header">
			<td onclick="sortTable(0);">Event Id</td>
			<td onclick="sortTable(1);">Student Number</td>
			<td onclick="sortTable(2);">First Name</td>
			<td onclick="sortTable(3);">Middle Name</td>
			<td onclick="sortTable(4);">Last Name</td>
			<td onclick="sortTable(5);">Year and Section</td>
		</tr>
	<?php
		include("connect.php");
		$curr_date = date("Y/m/d");
		$curr_date = str_replace('/','-',$curr_date);
		if(isset($_GET['search'])){
			$search = $_GET['search'];
			$select = mysqli_query($con, "SELECT * FROM participants WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR contact_number LIKE '%$search%' OR student_number LIKE '%$search%' OR gender LIKE '%$search%' OR section LIKE '%$search%'");
		} else {
			$select = mysqli_query($con, "SELECT participants.event_id, participants.student_number, participants.first_name, participants.middle_name, participants.last_name, participants.section FROM participants LEFT JOIN attendance ON attendance.event_id = participants.event_id WHERE attendance.event_id IS NULL");
		}
		if($select){
			if(mysqli_num_rows($select) > 0){
				while ($row = mysqli_fetch_assoc($select)){
					echo "<form method='POST' action='list.php'>
						<tr>
						<td>".$row['event_id']."</td>
						<td>".$row['student_number']."</td>
						<td>".$row['first_name']."</td>
						<td>".$row['middle_name']."</td>
						<td>".$row['last_name']."</td>
						<td>".$row['section']."</td>
						</tr>
						</form>
						";
				}
			} 
		} else {
			echo "<tr><td colspan='8'>EMPTY</td></tr>";
		}
	?>
<script>
	function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("table");
	  switching = true;
	  // Set the sorting direction to ascending:
	  dir = "asc"; 
	  /* Make a loop that will continue until
	  no switching has been done: */
	  while (switching) {
	    // Start by saying: no switching is done:
	    switching = false;
	    rows = table.getElementsByTagName("TR");
	    /* Loop through all table rows (except the
	    first, which contains table headers): */
	    for (i = 2; i < (rows.length - 1); i++) {
	      // Start by saying there should be no switching:
	      shouldSwitch = false;
	      /* Get the two elements you want to compare,
	      one from current row and one from the next: */
	      x = rows[i].getElementsByTagName("TD")[n];
	      y = rows[i + 1].getElementsByTagName("TD")[n];
	      /* Check if the two rows should switch place,
	      based on the direction, asc or desc: */
	      if (dir == "asc") {
	        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
	          // If so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      } else if (dir == "desc") {
	        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
	          // If so, mark as a switch and break the loop:
	          shouldSwitch= true;
	          break;
	        }
	      }
	    }
	    if (shouldSwitch) {
	      /* If a switch has been marked, make the switch
	      and mark that a switch has been done: */
	      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
	      switching = true;
	      // Each time a switch is done, increase this count by 1:
	      switchcount ++; 
	    } else {
	      /* If no switching has been done AND the direction is "asc",
	      set the direction to "desc" and run the while loop again. */
	      if (switchcount == 0 && dir == "asc") {
	        dir = "desc";
	        switching = true;
	      }
	    }
	  }
	}
</script>
</body>
</html>