<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- 
Author: Steven Nguyen
Date last modified: 05/09/2016
IS 448
Professor Sampath
This document will be used to allow users to access our website.
-->


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<!-- Title of the webpage -->
		<title>
			Login - Nature Seekers
		</title>
		
		<!-- CSS styling and javascript linking -->
		<link rel="stylesheet" href="style/lavish-bootstrap.css"/>
		<link rel="stylesheet" href="style/steven.css"/>
		<script type="text/javascript" src="login.js"></script>
		
	</head>
	
	<body id="body">
	
	<!-- Navigation bar -->
	<div class="navbar navbar-inverse" style="border-radius:0pt;">
		<div class="content">
			<span class="navbar-brand">
				Nature Seekers
			</span>
			<ul class="nav navbar-nav">
				<li class = "active"><a href="#">Home</a></li>
				<!-- If statement, if sessions are found, displays the rest of the navbar -->
				<?php
				if(isset($_SESSION['user_id'])){
					?>
				<li><a href="./points_of_interest.html ">Add Markers</a></li>
				<li ><a href="#">View Route</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
		  <li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
		<!-- End if statement -->
		<?php
				}
				?>
		</div>
	</div>
		
		<!-- First header of the webpage -->
		<h1 class="centerhead">
			<b>Welcome to Nature Seekers</b>
		</h1>
		<!-- Login form, if session is found, the form is hidden -->
		<?php
			if(!isset($_SESSION['user_id'])){
		?>
		<form action="login2.php" method="POST">
		<p class="login">
			Username: <input type="text" id="user" name="Username" size="25"/><br /><br />
			Password: <input type="password" id="pass" name="Password" size="25"/><br /><br />
			<?php
				if((($_SESSION['login_fail'] + 60 > time()))&&(!isset($_SESSION['user_id']))){
			?>
			<b>Your login combination was invalid. Please try again.</b><br />
			<?php
				}
			?>
			<form action="identify.php">
				<input type="submit" id="loginSubmit" value="Login" onclick="validateLogin()" />
			</form>
		</p>
		
		<!-- Links to assist problems logging in, if session is found, the buttons are hidden -->
		<p class="login">
			<input type="button" id="forgotButton" value="Forgot your Password?" onclick="forgotRedirect()" />
			<input type="button" id="registerButton" value="Not a member yet?" onclick="registerRedirect()" /><br />
		</p>
		
		</form>
		<?php
			}
		?>
		<!-- Description of webpage -->
		<h4 class="centerText">
			Nature Seekers is a website in which users are able to plot routes, 
			areas and points of interest on a map and comment on them for assorted 
			outdoor sports. The information may then be displayed to other users, 
			creating a user generated map of locations which pertain to specific outdoor 
			sports and user input on them. This will allow the users to both learn 
			about new places to enjoy their sport and and share their knowledge with 
			others about specific locations.<br /><br />
			
			<!-- A checkbox with a javascript function that changes the font color, background color, and button colors of this page -->
			<input type="checkbox" id="chk" value="Night Mode" onchange="nightMode()" /> Night Mode
		</h4>
		
	</body>
</html>
