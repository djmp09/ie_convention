
<!DOCTYPE html>
<html>
<head>
	<title>ID</title>
	<link href="style.css" rel="stylesheet" />
</head>
<body>
	<div>
		<img src="images/Template.jpg" >
		<p id="fn"> <?php if(isset($_GET['fn'])){ echo $_GET['fn'];} ?></p>
		<p id="ln"> <?php if(isset($_GET['ln'])){ echo $_GET['ln'];} ?> </p>
		<p id="number"> <?php if(isset($_GET['event_id'])){ echo $_GET['event_id'];} ?> </p>
	</div>

</body>
</html>