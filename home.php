<?php
/*Used to check whether a user has logged in or not. 
If not logged in then it redirects to login.php */
	session_start();
	if(!isset($_SESSION['id']))
	{
		header("Location: login.php");
	}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/home.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<title>Welcome</title>
</head>
<body>
<!--Used to store the elements. This covers entire screen-->
<div class="container">
	<!--Used to store the header elements-->
	<div id="header-container">
		<!--Used to store the header buttons -->
			<div id="personal">
				<img src="img/personal.png" class="glyph">
				<a href="personal.php"  id="personal-btn" class="btn">Personal</a>
			</div>
			<div id="achievements">
				<img src="img/achievements.png" class="glyph">
				<a href="achievements.php"  id="achievements-btn" class="btn">Achievements</a>
			</div>
			<div id="skills">
				<img src="img/skills.png" class="glyph">
				<a href="skills.php"  id="achievements-btn" class="btn">Skills</a>
			</div>
			<div id="interests">
				<img src="img/interests.png" class="glyph">
				<a href="interests.php"  id="achievements-btn" class="btn">Interests</a>
			</div>
			<a href="logout.php" class="button" id="logout">Logout</a>
	</div>
	<h1 id="wel-message">Welcome <?php echo $_SESSION['id']?></h1>
</div>
</body>
</html>