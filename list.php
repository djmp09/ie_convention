<?php
	include("connect.php");
	if(isset($_POST['delete'])){
		$id = $_POST["id"];
		$delete = mysqli_query($con, "DELETE FROM participants WHERE id='$id'");
		if($delete){
			$count = mysqli_query($con, "SELECT COUNT(*) AS total FROM participants");
			$result = $count->fetch_assoc();
			if($result['total'] == 0){
				$last = mysqli_query($con, "ALTER TABLE participants AUTO_INCREMENT=1");
				if(!$last){
					echo "Error: ". mysql_error($con);
				}
			} 
			echo "
				<script>
					alert('Another one left the FORCE!');
				</script>
			";
			
		}
	} else if(isset($_POST['edit'])){
		header("Location: add.php?event_id=".$_POST['event_id']);
	} else if(isset($_POST['link'])){
		header("Location: id.php?event_id=".$_POST['event_id']."&fn=".$_POST['fn']."&ln=".$_POST['ln']."");
	}
?>
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
			<th colspan="13">List of Participants</th>
		</tr>
		<tr class="header">
			<td onclick="sortTable(0);">Event Id</td>
			<td onclick="sortTable(1);">Student Number</td>
			<td onclick="sortTable(2);">First Name</td>
			<td onclick="sortTable(3);">Middle Name</td>
			<td onclick="sortTable(4);">Last Name</td>
			<td onclick="sortTable(5);">Year and Section</td>
			<td onclick="sortTable(6);">Gender</td>
			<td onclick="sortTable(7);">Contact Number</td>
			<td onclick="sortTable(8);">Mode of Payment</td>
			<td>Action</td>
		</tr>
			<?php
				if(isset($_GET['search'])){
					$search = $_GET['search'];
					$select = mysqli_query($con, "SELECT * FROM participants WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR contact_number LIKE '%$search%' OR student_number LIKE '%$search%' OR gender LIKE '%$search%' OR section LIKE '%$search%'");
				} else {
					$select = mysqli_query($con, "SELECT * FROM participants");
				}
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
							<td>".$row['gender']."</td>
							<td>".$row['contact_number']."</td>
							<td>".$row['mode_of_payment']."</td>
							<td>
								<input type='hidden' name='id' value='".$row['id']."'>
								<input type='hidden' name='event_id' value='".$row['event_id']."'>
								<input type='hidden' name='fn' value='".$row['first_name']."'>
								<input type='hidden' name='ln' value='".$row['last_name']."'>
								<input type='submit' name='link' value='Link'>
								<input type='submit' name='delete' value='Delete'>
								<input type='submit' name='edit' value='Edit'>
							</td>
							</tr>
							</form>
							";
					}
				}
			?>
		<tr>
			<td colspan="10"><input type="button" onclick="myFunction()" id="print" value="PRINT"></td>
		</tr>
	</table>
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
	    for (i = 2; i < (rows.length - 2); i++) {
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

	function myFunction(){
        var x = document.getElementById("print");
        x.style.display = "none";
        window.print();
        window.location.reload(true);
    }
</script>
</body>
</html>