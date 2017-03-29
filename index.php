
<?php
/*Used to check whether a user has logged in or not. 
If logged in then it directly skips to home.php */
session_start();
if(isset($_SESSION['id']))
{
	header("Location: home.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<title>RO SAT</title>
</head>
<body>
<div class="container">
	<div id="title"><h1>RNSIT&nbsp;   PLACEMENTS</h1></div>
	<div class="button-container">
			<a href="login.php" class="button" id="login">Login</a>
			<a href="register.php" class="button" id="register">Register</a>
	</div>
</div>
</body>
</html>