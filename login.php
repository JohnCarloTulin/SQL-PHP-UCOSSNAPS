<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

	if ($_SESSION['status'] == "200") {
		echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
	}

	else {
		echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
	}

}

unset($_SESSION['message']);
unset($_SESSION['status']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<h1>Login Now!</h1>

	<!-- Input form for username and password -->
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="username">Password</label>
			<input type="password" name="password">
			<input type="submit" name="loginUserBtn" style="margin-top: 25px; ">
		</p>
	</form>

	<!-- User has the option to register -->
	<p>Don't have an account? You may register <a href="register.php">here</a></p>
</body>
</html>