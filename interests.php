<?php
/*Used to check whether a user has logged in or not. 
If not logged in then it redirects to login.php */
	session_start();
	if(!isset($_SESSION['id']))
	{
		header("Location: login.php");
	}
	require_once('connect.php');
	$email=$_SESSION['email'];
	$query = "SELECT * FROM `interests` WHERE Email='$email'";
	$interests = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$Arr=array();
	$i=1;
	while($row=mysqli_fetch_array($interests)){
		$Arr[$i]=$row;
		$i++;
	}
	if(isset($_POST['interests-submit']))
	{
		$Interests=$_POST['Interests'];
		$query = "INSERT INTO `interests` (Email,Iname) VALUES ('$email','$Interests')";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		header("Location: interests.php");
	}
	for($i=1;$i<=sizeof($interests)+1;$i++)
	{
		if(isset($_POST['delete'.$i]))
		{
			$id=$Arr[$i]['InterestId'];
			$query="DELETE FROM `interests` WHERE InterestId='$id'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			header("Location: interests.php");
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/interests.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script>
		$(document).ready(function(){
			var no_rows=parseInt("<?php echo mysqli_num_rows($interests);?>");
			var Array = <?php echo json_encode($Arr); ?>;

			$("#edit-interests").on('click',function(){
				$("#form-interests").removeClass().addClass("forms-visible");
				$("#interests-close").on('click',function(){
					$("#form-interests").removeClass().addClass("forms-invisible");
				});
			});
			for(var i=1;i<=no_rows;i++)
			{
				$("#interestsTable").append("<span style='color:#254c14;'>"+i+"</span></br><span style='color:#0000ff'>Interest:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Iname']+
					"</br>"+
					"<form method='POST'><input id='delete"+i+"' type='submit' style='padding: 10px;background: #5a1a75;color: #fff;font-family:font1;border-radius:15px;' value='Delete' name='delete"+i+"'></input></form></br></br>");
			}

		});
	</script>
	<title><?php echo $_SESSION['id']?>-interests</title>
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
	<div id="details">
		<h1><span class="details-title">interests :</span></h1>
		<div class="edit"><input id="edit-interests" type="button" value="Add" class="edit-button"></div>
		<div class="individual-details">
		<p id="interestsTable">
		</p>
		</div>
	</div>
	
	<div id="form-interests" class="forms-invisible">
		<a id="interests-close"><img src="img/close-btn.png" id="close-btn"></a>
		<form method="post">
		<p>
			Interests: </br>
			<input type="text" name="Interests" value=" " </br></br></br>
			<input type="submit" name="interests-submit" value="submit" id="submit">
		</p>
		</form>
	</div>
</div>
</body>
</html>