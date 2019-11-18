<?php include("server.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>User registration system using PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Edit</h2>
	</div>
	
	<form method="post" action="edit.php">
	<!-- Display validation errors here -->
	<?php include("errors.php"); ?>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $_SESSION["username"] ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="text" name="email" value="">
	</div>
	<div class="input-group">
		<label>New password</label>
		<input type="password" name="password_1" value="">
	</div>
	<div class="input-group">
		<label>Password confirm</label>
		<input type="password" name="password_2" value="">
	</div>
	<div class="input-group">
		<button type="submit" name="edit" class="btn">Edit</button>
	</div>
<form>
	
</body>
</html>