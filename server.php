<?php
	session_start();
	
	$username = "";
	$email = "";
	$errors = array();

	// connect to the database
	$db = mysqli_connect("localhost", "root", "", "usersDB");
	
	// if register button is clicked
	if (isset($_POST["register"])) {
		$username = $_POST["username"];
		$email = mysqli_real_escape_string($db, $_POST["email"]);
		$password_1 = mysqli_real_escape_string($db, $_POST["password_1"]);
		$password_2 = mysqli_real_escape_string($db, $_POST["password_2"]);
		
		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}
		
		// is there are no errors, save user to database
		if (count($errors) == 0) {
			if(!user_exist($username, $email)) {
				$password = md5($password_1); // encrypt password before storing in database (securiry)
				$sql = "INSERT INTO users (username, email, password, role_id) VALUES ('$username', '$email', '$password', '2')";
				$db->query($sql);
				login($username, $password);
			} else {
				array_push($GLOBALS["errors"], "This username or email already exist");
			}
		}
		
	}
	
	// log user in form login page
	if (isset($_POST["login"])) {
		$username = mysqli_real_escape_string($db, $_POST["username"]);
		$password = mysqli_real_escape_string($db, $_POST["password"]);
		
		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}
		
		if (count($errors) == 0) {
			$password = md5($password); // encrypt password before comparing with that from database
			login($username, $password);
		}
	}
	
	// logout
	if (isset($_GET["logout"])) {
		session_destroy();
		unset($_SESSION["username"]);
		unset($_SESSION["role"]);
		header("location: login.php");
	}
	
	// edit user
	if (isset($_POST["edit"])) {
		edit();
	}
	
	// delete user
	if (isset($_POST["delete"])) {
		$username = mysqli_real_escape_string($db, $_POST["username"]);
		
		$user = getUser($username);
		
		if (isset(mysqli_fetch_array($user)["username"])) {
			$query = "DELETE FROM users WHERE username = '$username'";
			$db->query($query);
			echo "<script>alert('User ".$username." was deleted successfuly');</script> }";
		} else {
			echo "<script>alert('Error deleting user');</script>";
		}
		
	}
?>

<?php
	function login($username, $password) {
		$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$result = $GLOBALS["db"]->query($query);
		if (mysqli_num_rows($result) == 1) {
			// log user in
			// get user role
			$role_id = mysqli_fetch_array($result)["role_id"];
			// start session
			$_SESSION["username"] = $username;
			$_SESSION["role"] = getRoleName($role_id);
			$_SESSION["success"] = "You are now logged in";
			
			header("location: index.php"); // redirect to home page
		} else {
			array_push($GLOBALS["errors"], "wrong username/password combination");
		}
	}
	
	function edit() {
		$db = $GLOBALS["db"];
		$username = mysqli_real_escape_string($db, $_POST["username"]);
		$email = mysqli_real_escape_string($db, $_POST["email"]);
		$password_1 = mysqli_real_escape_string($db, $_POST["password_1"]);
		$password_2 = mysqli_real_escape_string($db, $_POST["password_2"]);
		
		//ensure that form fields are filled properly
		if (empty($username)) {
			array_push($GLOBALS["errors"], "Username is required");
		}
		if (empty($email)) {
			array_push($GLOBALS["errors"], "Email is required");
		}
		if (empty($password_1)) {
			array_push($GLOBALS["errors"], "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($GLOBALS["errors"], "The two passwords do not match");
		}
		
		if (count($GLOBALS["errors"]) == 0) {
			if (!user_exist($username, $email)) {
				$password = md5($password_1); // encrypt password before comparing with that from database
				$query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE username='".$_SESSION['username']."'";
				$db->query($query);
				$_SESSION["username"] = $username;
				header("location: index.php");
			} else {
				array_push($GLOBALS["errors"], "This username or email already exist");
			}
		}
	}
	
	function user_exist($username, $email) {
		$query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
		$result = $GLOBALS["db"]->query($query);
		
		return count(mysqli_fetch_array($result)) > 0;
	}
	
	// по id връща името на ролята
	function getRoleName($role_id) {
		$query = "SELECT role FROM roles WHERE id = '$role_id'";
		$result = $GLOBALS["db"]->query($query);
		return mysqli_fetch_array($result)["role"];
	}
	
	function getUser($username) {
		$query = "SELECT * FROM users WHERE username='$username'";
		return $GLOBALS['db']->query($query);
	}
?>