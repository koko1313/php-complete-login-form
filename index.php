<?php include("server.php");

	// if user is not logged in, they cannot access this page
	if (empty($_SESSION["username"])) {
		header("location: login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User registration system using PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Home page</h2>
	</div>
	
	<div class="content">
		<?php if (isset($_SESSION["success"])): ?>
			<div class="error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		
		<?php if (isset($_SESSION["username"])): ?>
			<p>Welcome <strong><?php echo $_SESSION["username"]; ?></strong></p>
			<p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
			<p><a href="edit.php" style="color: orange;">Edit</a></p>
		<?php endif ?>
	</div>
	
	<?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
		<form method="post" action="index.php">
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username">
			</div>
			<div class="input-group">
				<button type="submit" name="delete" class="btn">Delete User</button>
			</div>
		</form>
	<?php endif ?>
	
</body>
</html>