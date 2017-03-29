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
	$query = "SELECT * FROM `skills` WHERE Email='$email'";
	$skills = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$Arr=array();
	$i=1;
	while($row=mysqli_fetch_array($skills)){
		$Arr[$i]=$row;
		$i++;
	}
	if(isset($_POST['skills-submit']))
	{
		$Sname=$_POST['Title'];
		$Institution=$_POST['Institution'];
		$Period=$_POST['Period'];
		$Date=$_POST['Date'];
		$Details=$_POST['Details'];
		$CId=$_POST['Cid'];
		$query = "INSERT INTO `skills` (Email,Sname,Institute,CertificateId,Period,Date,Details) VALUES ('$email','$Sname','$Institution','$CId','$Period','$Date','$Details')";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		header("Location: skills.php");
	}
	for($i=1;$i<=sizeof($skills)+1;$i++)
	{
		if(isset($_POST['delete'.$i]))
		{
			$id=$Arr[$i]['Sid'];
			$query="DELETE FROM `skills` WHERE Sid='$id'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			header("Location: skills.php");
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/skills.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script>
		$(document).ready(function(){
			var no_rows=parseInt("<?php echo mysqli_num_rows($skills);?>");
			var Array = <?php echo json_encode($Arr); ?>;

			$("#edit-skills").on('click',function(){
				$("#form-skills").removeClass().addClass("forms-visible");
				$("#skills-close").on('click',function(){
					$("#form-skills").removeClass().addClass("forms-invisible");
				});
			});
			for(var i=1;i<=no_rows;i++)
			{
				$("#skillsTable").append("<span style='color:#254c14;'>"+i+"</span></br><span style='color:#0000ff'>Skill Name:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Sname']+
					"</br><span style='color:#0000ff'>Certificate Id:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['CertificateId']+
					"</br><span style='color:#0000ff'>Institution:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Institute']+
					"</br><span style='color:#0000ff'>Date:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Date']+"</br>"+
					"<span style='color:#0000ff'>Period:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Period']+"</br>"+
					"<span style='color:#0000ff'>Details:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Details']+"</br>"+
					"</br>"+
					"<form method='POST'><input id='delete"+i+"' type='submit' style='padding: 10px;background: #5a1a75;color: #fff;font-family:font1;border-radius:15px;' value='Delete' name='delete"+i+"'></input></form></br></br>");
			}

		});
	</script>
	<title><?php echo $_SESSION['id']?>-Skills</title>
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
		<h1><span class="details-title">skills :</span></h1>
		<div class="edit"><input id="edit-skills" type="button" value="Add" class="edit-button"></div>
		<div class="individual-details">
		<p id="skillsTable">
		</p>
		</div>
	</div>
	
	<div id="form-skills" class="forms-invisible">
		<a id="skills-close"><img src="img/close-btn.png" id="close-btn"></a>
		<form method="post">
		<p>
			Skill Name: </br>
			<input type="text" name="Title" value=" " </br></br></br>
			Institution: </br>
			<input type="text" name="Institution" value=" " </br></br></br>
			Certificate Id: </br>
			 <input type="text" name="CId" value=" " </br></br></br>
			Period: </br>
			 <input type="text" name="Period" value=" " </br></br></br>
			Date: </br>
			<input type="text" name="Date" value=" " </br></br></br>
			Details: </br>
			<input type="text" name="Details" value=" " </br></br></br>
			<input type="submit" name="skills-submit" value="submit" id="submit">
		</p>
		</form>
	</div>
</div>
</body>
</html>