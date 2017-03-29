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
	$query = "SELECT * FROM `users` WHERE Email='$email' LIMIT 1";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$row = mysqli_fetch_array($result);
	$fname=$row['Fname'];
	$sname=$row['Sname'];
	$aadhar=$row['Aadhar'];
	$dob=$row['DOB'];
	$phone=$row['Phone'];
	$pic=$row['pic'];
	$newDob="";
	$newPhone=0;
	$query = "SELECT * FROM `PARENTS` WHERE Email='$email' LIMIT 1";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$parents=mysqli_fetch_array($result);
	$query = "SELECT * FROM `education` WHERE Email='$email'";
	$colleges = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$Arr=array();
	$i=1;
	while($row=mysqli_fetch_array($colleges)){
		$Arr[$i]=$row;
		$i++;
	}
	if(isset($_POST['you-submit']))
	{
		$newFname=$_POST['fname'];
		$newSname=$_POST['sname'];
		$newAadhar=$_POST['aadhar'];
		if(isset($_POST['dob']))
			$newDob=$_POST['dob'];
		if(isset($_POST['phone']))
			$newPhone=$_POST['phone'];
		$query = "UPDATE `users` SET Fname='$newFname',Sname='$newSname',Aadhar='$newAadhar',Phone='$newPhone',DOB='$newDob' WHERE Email='$email'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		header("Location: personal.php");
	}
	if(isset($_POST['parents-submit']))
	{
		$Father=$_POST['Father'];
		$Fatherphone=$_POST['Father-phone'];
		$FatherOccupation=$_POST['Father-Occupation'];
		$Mother=$_POST['Mother'];
		$Motherphone=$_POST['Mother-phone'];
		$MotherOccupation=$_POST['Mother-Occupation'];
		$query = "UPDATE `parents` SET Father='$Father',FatherPhone='$Fatherphone',FatherOccupation='$FatherOccupation',Mother='$Mother',MotherPhone='$Motherphone',MotherOccupation='$MotherOccupation' WHERE Email='$email'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		header("Location: personal.php");
	}
	if(isset($_POST['education-submit']))
	{
		$Institution=$_POST['Institution'];
		$Class=$_POST['Class'];
		$Percentage=$_POST['Percentage'];
		$Year=$_POST['Year'];
		$query = "INSERT INTO `education` (Email,Institution,Class,Percentage,Year) VALUES ('$email','$Institution','$Class','$Percentage','$Year')";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		header("Location: personal.php");
	}
	for($i=1;$i<=sizeof($colleges);$i++)
	{
		if(isset($_POST['delete'.$i]))
		{
			$id=$Arr[$i]['Collegeid'];
			$query="DELETE FROM `education` WHERE Collegeid='$id'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			header("Location: personal.php");
		}
	}

	if(isset($_POST['picture-submit']))
	{
		$imagename=$_FILES["myimage"]["name"]; 
		//Get the content of the image and then add slashes to it 
		$imagetmp=addslashes (file_get_contents($_FILES['myimage']['tmp_name']));
		$insert_image="UPDATE `users` SET pic='$imagetmp',picName='$imagename' WHERE Email='$email'";
		$result = mysqli_query($connection, $insert_image) or die(mysqli_error($connection));
			header("Location: personal.php");
		imagedestroy( $dst );
	}

?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/personal.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<script type="text/javascript" src="js/jquery-3.1.1.js"></script>
	<script type="text/javascript" src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script>
		$(document).ready(function(){
			var no_rows=parseInt("<?php echo mysqli_num_rows($colleges);?>");
			var Array = <?php echo json_encode($Arr); ?>;
			$("#edit-you").on('click',function(){
				$("#form-you").removeClass().addClass("forms-visible");
				$("#you-close").on('click',function(){
					$("#form-you").removeClass().addClass("forms-invisible");
				});
			});
			$("#edit-parents").on('click',function(){
				$("#form-parents").removeClass().addClass("forms-visible");
				$("#parents-close").on('click',function(){
					$("#form-parents").removeClass().addClass("forms-invisible");
				});
			});
			$("#edit-education").on('click',function(){
				$("#form-education").removeClass().addClass("forms-visible");
				$("#education-close").on('click',function(){
					$("#form-education").removeClass().addClass("forms-invisible");
				});
			});
			$("#picture-button").on('click',function(){
				$("#form-picture").removeClass().addClass("forms-visible");
				$("#picture-close").on('click',function(){
					$("#form-picture").removeClass().addClass("forms-invisible");
				});
			})
			for(var i=1;i<=no_rows;i++)
			{
				$("#collegesTable").append("<span style='color:#254c14;'>"+i+"</span></br><span style='color:#0000ff'>Institution:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Institution']+
					"</br><span style='color:#0000ff'>Class:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Class']+
					"</br><span style='color:#0000ff'>Year:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Year']+
					"</br><span style='color:#0000ff'>Percentage:</span>&nbsp;&nbsp;&nbsp;&nbsp;"+Array[i]['Percentage']+"</br></br>"+
					"<form method='POST'><input id='delete"+i+"' type='submit' style='padding: 10px;background: #5a1a75;color: #fff;font-family:font1;border-radius:15px;' value='Delete' name='delete"+i+"'></input></form></br></br>");
			}

		});
	</script>
	<title><?php echo $_SESSION['id']?>-Personal</title>
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
	<div id="picture-container">
	<?php
		echo '<img style="width:350px;height:350px;" src="data:image/jpeg;base64,'.base64_encode($pic).'"/>';
	?>
		<input type="button" id="picture-button" value="Upload" style="position:absolute;font-family: font1;bottom: 0;left:0;"></input>
	</div>
	<div id="details">
		<h1><span class="details-title">YOU :</span></h1>
		<div class="edit"><input id="edit-you" type="button" value="Edit" class="edit-button"></div>
		<div class="individual-details">
		<p>
			<span id="para-color">First Name:</span>&nbsp;&nbsp;
			<?php echo $fname ?> &nbsp;&nbsp;
			<span id="para-color">Second Name:</span>&nbsp;&nbsp;
			<?php echo $sname ?></br>
			<span id="para-color">Aadhar No.:</span>&nbsp;&nbsp;
			<?php echo $aadhar ?></br>
			<span id="para-color">Email:</span>&nbsp;&nbsp;
			<?php echo $email ?></br>
			<span id="para-color">DOB:</span>&nbsp;&nbsp;
			<?php echo $dob ?></br>
			<span id="para-color">Phone:</span>&nbsp;&nbsp;
			<?php echo $phone ?></br>
		</p>
		</div>
		<h1><span class="details-title">PARENTS :</span></h1>
		<div class="edit"><input id="edit-parents" type="button" value="Edit" class="edit-button"></div>
		<div class="individual-details">
		<p>
			<span id="para-color">Father:</span>
			<?php echo $parents['Father'] ?> &nbsp;&nbsp;</br>
			<span id="para-color">Ph.No:</span>
			<?php echo $parents['FatherPhone'] ?></br>
			<span id="para-color">Occupation:</span>
			<?php echo $parents['FatherOccupation'] ?></br></br>
			<span id="para-color">Mother:</span>
			<?php echo $parents['Mother'] ?></br>
			<span id="para-color">Ph.No:</span>
			<?php echo $parents['MotherPhone'] ?></br>
			<span id="para-color">Occupation</span>
			<?php echo $parents['MotherOccupation'] ?></br>
		</p>
		</div>
		<h1><span class="details-title">Education :</span></h1>
		<div class="edit"><input id="edit-education" type="button" value="Add" class="edit-button"></div>
		<div class="individual-details">
		<p id="collegesTable">
		</p>
		</div>
	</div>
	<div id="form-you" class="forms-invisible">
		<a id="you-close"><img src="img/close-btn.png" id="close-btn"></a>
		<form method="post">
		<p>
			First Name: </br>
			<input type="text" name="fname" required="required" value=<?php echo $fname;?> placeholder=<?php echo $fname;?>></br></br>
			Second Name: </br>
			<input type="text" name="sname" required="required" value=<?php echo $sname;?> placeholder=<?php echo $sname;?>></br></br>
			Aadhar No.: </br>
			 <input type="text" name="aadhar" required="required" value=<?php echo $aadhar;?> placeholder=<?php echo $aadhar;?>></br></br>
			 Phone No.: </br>
			 <input type="text" name="phone" placeholder="Phone"></br></br>
			 Date of Birth: </br>
			 <input type="text" name="dob" placeholder="DD-MM-YYYY"></br></br>
			 <input type="submit" name="you-submit" value="submit" id="submit">
		</p>
		</form>
	</div>
	<div id="form-parents" class="forms-invisible">
		<a id="parents-close"><img src="img/close-btn.png" id="close-btn" ></a>
		<form method="post">
		<p>
			Father Name: </br>
			<input type="text" name="Father" value=" "> </br></br>
			Father Phone: </br>
			<input type="text" name="Father-phone" value=" "> </br></br>
			Father Occupation: </br>
			 <input type="text" name="Father-Occupation" value=" " ></br></br>
			Mother Name: </br>
			<input type="text" name="Mother" value=" " ></br></br>
			Mother Phone: </br>
			<input type="text" name="Mother-phone" value=" " ></br></br>
			Mother Occupation: </br>
			 <input type="text" name="Mother-Occupation" value=" "> </br></br>
			 <input type="submit" name="parents-submit" value="submit" id="submit">
		</p>
		</form>
	</div>
	<div id="form-education" class="forms-invisible">
		<a id="education-close"><img src="img/close-btn.png" id="close-btn"></a>
		<form method="post">
		<p>
			Institution: </br>
			<input type="text" name="Institution" value=" " </br></br></br>
			Class: </br>
			<input type="text" name="Class" value=" " </br></br></br>
			Percentage: </br>
			 <input type="text" name="Percentage" value=" " </br></br></br>
			Year: </br>
			<input type="text" name="Year" value=" " </br></br></br>
			<input type="submit" name="education-submit" value="submit" id="submit">
		</p>
		</form>
	</div>
	<div id="form-picture" class="forms-invisible">
		<a id="picture-close"><img src="img/close-btn.png" id="close-btn"></a>
		<form method="post" enctype="multipart/form-data">
		<p>
			<input type="file" name="myimage" id="upload-btn" style="margin-top: 100px;margin-left: 50;padding: 10px;">
			<input type="submit" name="picture-submit" value="Upload" id="submit"></br>
			NOTE: Image size should be 350px * 350px 
		</p>
		</form>
	</div>
</div>
</body>
</html>