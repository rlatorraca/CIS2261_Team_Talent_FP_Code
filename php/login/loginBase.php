<?php
/**
 * Created by PhpStorm.
 * User: jgaudet109873
 * Date: 1/22/2019
 * Time: 5:34 PM
 */

?>
<?php
session_start();

//Login processing logic here
if (isset($_POST['username'])) {
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	if ($_SESSION['username'] == '' || $_SESSION['password'] == '') {
		$error = "You need a Username and  Password";
		$_SESSION['isLoggedIn'] = false;
	} else {

		include "../dbConn.php";

		if (mysqli_connect_errno()) {
			$error = "Error: Could not connect to database. Please try again later.";
			exit;
		}

		$usernamedb = $database->real_escape_string(trim($_SESSION['username']));
		$passworddb = $database->real_escape_string(md5(trim($_SESSION['password'])));

		$query = "SELECT username, password, accessCode FROM user WHERE (username = '$usernamedb') AND (password = '$passworddb') LIMIT 1";


		//$db object created above and run the query() method. We pass it our query from above.
		$result = $database->query($query);
		$num_results = $result->num_rows;

		//if result is false [don't have any register in the database]
		if ($num_results == 0) {
			$error = "Login/Password incorrect";
		} else {
			if ($num_results == 1) {
				$row = $result->fetch_assoc();
				$accessCodeDB = $row['accessCode'];
				$_SESSION['isLoggedIn'] = true;
				$_SESSION['accessCode'] = $accessCodeDB;
				include("setCookie.php");
				echo "<p>My access code is : " . $_SESSION['accessCode'] . "<p>";
				$error = "Logged IN";
				//header('Location: index.php');
			} else {
				$error = "Login/Password incorrect";
				exit;
			}
		}
	}
}
?>
<form action="loginBase.php" method="post">
	<div class="form-group">
		<label for="user">Username:</label>
		<input type="text" name="username" id="user" placeholder="Enter your username" class="form-control"
		<?php if (isset($_COOKIE['stars'])) {
			echo "value='" . $_COOKIE['stars'] . "'>";
		} else {
			echo "value=''/>";
		} ?>
		<br>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" placeholder="Enter your password"
		       class="form-control"/><br>
		<input type="submit" name="submit" value="Login" class="btn btn-default"/>
	</div>
</form>
<?php
if (isset($error)) {
	echo "<div class='alert alert-danger'>$error</div>";
}


?>
