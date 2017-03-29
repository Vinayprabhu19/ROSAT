<?php
//used to import the connect.php file
require_once('connect.php');

/*check if superglobals i.e. $_POST(array) is set or not.....
 $_POST is set when we fill the form of method="post" and it contains
 all the values entered in the form  */
 $password="password";
 $rpassword="rpassword";
 $result="";
 $emailCheck="True";
 if(isset($_SESSION['id']))
	{
		header("Location: home.php");
	}
if(isset($_POST) & !empty($_POST))
{

	//sanitize the inputs by removing special characters to prevent SQL Injections

	$firstname = mysqli_real_escape_string($connection, $_POST['fname']);
	$lastname = mysqli_real_escape_string($connection, $_POST['lname']);
	$email = mysqli_real_escape_string($connection, $_POST['email']);
	$aadhar = mysqli_real_escape_string($connection, $_POST['aadhar']);
	
	//md5() is a hashing algo used to hide password

	$password = md5(mysqli_real_escape_string($connection, $_POST['password']));
	$rpassword = md5(mysqli_real_escape_string($connection, $_POST['password2']));

	if($password == $rpassword)
	{
		//Insert query to insert values into db
		if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        	$emailCheck="False";
    	}
    	if($emailCheck=="True")
    	{
		$sql = "INSERT INTO `users` (Fname, Sname, Email, Aadhar, Password) VALUES ('$firstname',  '$lastname', '$email', '$aadhar', '$password') ";
		$result = mysqli_query($connection, $sql);

		$sql = "INSERT INTO `parents` (Email) VALUES ('$email') ";
		$result = mysqli_query($connection, $sql);

		$sql = "INSERT INTO `skills` (Email) VALUES ('$email') ";
		$result = mysqli_query($connection, $sql);

		$sql = "INSERT INTO `achievements` (Email) VALUES ('$email') ";
		$result = mysqli_query($connection, $sql);

		$sql = "INSERT INTO `interests` (Email) VALUES ('$email') ";
		$result = mysqli_query($connection, $sql);
		}
	}

}

?>


<!DOCTYPE html>
<html>
<head>
	<title>RO SAT-Register</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<!--Container stores the entire document which fits the whole screen -->
	<div id="container">
		</br></br></br>
		<div id="selection">
			<a type="button" name="login" href="login.php" id="login">LOGIN</a>
			<a type="button" name="register" href="register.php" id="register">REGISTER</a>
		</div>
		<!--Used to represent the registration form with different fields-->
		<div id="regform">
		<!--Redirects to itself after a post method on submitting-->
		<form method="POST" name="loginform" id="registerform">
			<input type="text" name="fname" id="fname" required="required" placeholder="First Name"></br>
			<input type="text" name="lname" id="lname" required="required" placeholder="Last Name"></br>
			<input type="text" name="email" id="email" required="required" placeholder="Email"></br>
			<input type="text" name="aadhar" id="aadhar" required="required" placeholder="Aadhar No."></br>
			<input type="password" name="password" id="password" required="required" placeholder="Password"></br>
			<input type="password" name="password2" id="password2" required="required" placeholder="Re-Enter password"></br>
			<input type="submit" name="submit" value="Register">
		</form>
		<!--Used to give out a message to the user on successful or unsuccessful registration-->
		<div class="message">
			<?php
				if($emailCheck!="True")
					echo "<h1 style='color:red;font-size:15px;margin-top:0px;'>Incorrect email </h1>";
				else if($password == $rpassword)
				{
					if($result)
					{
						echo "<h1 style='color:green;font-size:15px;margin-top:0px;'>User Registration successful!</h1>";
					}
					else
					{
						echo "<h1 style='color:red;font-size:15px;margin-top:0px;'>Registration failed.Check the details entered.</h1>";
					}
				}
				else if($password=="password" &&$rpassword=="rpassword"){
					
				}
				else
				{
						echo "<h1 style='color:red;font-size:15px;margin-top:0px;'>password doesn't match</h1>";
				}
			?>
		</div>
		</div>
	</div>
</body>
</html>