
<?php
/*Create a session.
 A session is a way to store information (in variables) to be used across multiple pages.*/
session_start();

//used to import the connect.php file
require_once('connect.php');

/*check if superglobals i.e. $_POST(array) is set or not.....
 $_POST is set when we fill the form of method="post" and it contains
 all the values entered in the form  */
$pwd="";
$db_password="";
if(isset($_SESSION['id']))
	{
		header("Location: home.php");
	}
if (isset($_POST['email']) && isset($_POST['password']))
{
	//remove the slashes and tags to avoid SQL Injection
	$email = stripslashes(strip_tags($_POST['email']));
	$pwd = stripslashes(strip_tags($_POST['password']));

	//Remove special char
	$email = mysqli_real_escape_string($connection, $email);
	$pwd = md5(mysqli_real_escape_string($connection, $pwd));

	//get the info of the user and store it in $result
	$query = "SELECT * FROM `users` WHERE Email='$email' LIMIT 1";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

	//store the result in $row array
	$row = mysqli_fetch_array($result);
	//Get the database password 
	$db_password = $row['Password'];
	//Check if passwords match
	$name=$row['Fname'];
	if($pwd == $db_password)
	{	
		echo "hello";
		//create a session cookie and go to home.php
		$_SESSION['email'] = $email;
		$_SESSION['id'] = $name;
		header("Location: home.php");
	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>RO SAT-Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="container">
		</br></br></br></br></br>
		<div id="selection">
			<a type="button" name="login" href="login.php" id="login">LOGIN</a>
			<a type="button" name="register" href="register.php" id="register">REGISTER</a>
		</div>
		<div id="form">
		<form method="post" name="loginform" id="loginform">
			<input type="text" name="email" id="username" required="required" placeholder="Email"></br>
			<input type="password" name="password" id="password" required="required" placeholder="Password">
			<input type="submit" name="submit" value="Login">
		</form>
		<div class="error">
		<?php
			if($pwd != $db_password){
				echo "<h1 class='error'>Please check the email and password</h1>";
			}
		?>
		</div>
		</div>
	</div>
</body>
</html>