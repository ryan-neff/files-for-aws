<?php 
/*
	Ryan Neff
	rcn6f4 | 14154018
	Challegnge 3

!!!! WEBSITE URL: http://ec2-54-68-45-194.us-west-2.compute.amazonaws.com/challenge3.php    !!!!!!!!!!
*/
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Challenge 3</title>
</head>
<body>
	<div align = "center" width="500px">
		<div id = "info">
			<p> Enter Your Info <br>
				<form action="challenge3.php" method="post">
					<label for="firstName">First Name:</label><br>
					<input type= "text" name="firstName" id="firstName"><br>
					<label for="lastName">Last Name:</label><br>
					<input type="text" name="lastName" id="lastName"><br>
					<label for="city">City:</label><br>
					<input type="text" name="city" id="city"><br>
					<label for="state">State:</label><br>
					<input type="text" name="state" id="state"><br>
					<label for="age">Age:</label><br>
					<input type="text" name="age" id="age"><br>
					<label for="phoneNumber">Phone Number:</label><br>
					<input type="text" name="phoneNumber" id="phoneNumber">
					<br>
			  		<input type="submit" name="submit" value="submit">
				</form>
			</p>
		</div>
	</div>
	<?php
		if(isset($_POST['submit'])) { 

			//set post variales from form
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$age = $_POST['age'];
			$phoneNumber = $_POST['phoneNumber'];

			//make sure all fields are filled out
			if(trim($firstName) == "" || trim($lastName) == "" || trim($city) == "" || trim($state) == "" || trim($age) == "" || trim($phoneNumber) == ""){
				echo '<script type="text/javascript"> alert("You must fill out all fields!");</script>';
			} else {
				//hide the form..
				?>
				<script type="text/javascript"> document.getElementById("info").style.display="none"; </script>
				<?php 
					//create a session variable for the phone number
					$_SESSION['phoneNumber'] = $phoneNumber;
					
					//create a cookie for the age
					$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; 
					setcookie("age", $age, time()+311040, "/", $domain, false);
					$_COOKIE['age'] = $age;
					
					//echo the form for hidden city and state post vairables, first and last name get variables
					echo "<form method='post' action='challenge3.php?firstName=$firstName&lastName=$lastName'>
						<input type='hidden' name='city' value=$city>
						<input type='hidden' name='state' value=$state>"; ?>
						
						<input type="submit" name="submitToPage3" id="submit3">

<?php 
			}
		}

	if(isset($_POST['submitToPage3'])) {
 		session_start();
 	
		if(!isset($_COOKIE['age'])){
			echo "Cookie is not set";
		}
		//set the fields by correct HTTP types
 		$firstName = $_GET['firstName'];
 		$lastName = $_GET['lastName'];
 		$city = $_POST['city'];
 		$state = $_POST['state'];
 		$phoneNumber = $_SESSION['phoneNumber'];
 		$age = $_COOKIE['age'];

 		//present the data to the screen.
 		?>
	<script type="text/javascript"> document.getElementById("info").style.display="none"; </script>
	<div>
		<table border="1">
			<tr><td>First Name:<td><td><?php echo $firstName ?></td></tr>
			<tr><td>Last Name:<td><td><?php echo $lastName ?></td></tr>
			<tr><td>City:<td><td><?php echo $city ?></td></tr>
			<tr><td>State:<td><td><?php echo $state ?></td></tr>
			<tr><td>Age:<td><td><?php echo $age ?></td></tr>
			<tr><td>Phone Number:<td><td><?php echo $phoneNumber ?></td></tr>
	
		</table>

 <?php		
 	}	
	?>
</body>
</html>