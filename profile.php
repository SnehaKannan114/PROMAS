<?php
	session_start();
?>
<!DOCTYPE html>
<html lang = "en-US">
	<head>
		<meta charset = "UTF-8">
		<title>Home</title>
		<link rel = "stylesheet" type = "text/css"  href = "./css/home.css" />

	</head>
	<body>
		<div id="header">
			<div class="topnav" id="myTopnav">
				<div class="links">
					<a href="./logout.php?logout=1">Logout</a>
					<a href="#about">About</a>				
					<a href="#dashboard">Dashboard</a>
					<a href="./index.php">Home</a>
					
				</div>
				<div class="drop" id="main">
					<a href="#" class="icon" onclick="openSideNav()">&#9776;</a>
				</div> 
				<a href="./profile.html">
					<img src="./img/circle.png" alt = "Profile"/>
				</a>
				
			</div>

			<div id="mySidenav" class="sidenav">
				<a href="javascript:void(0)" class="closebtn" onclick="closeSideNav()">&times;</a>
				<img src="./img/circle.png" alt = "Profile"/>
				<?php
				$link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

			        // Check connection
			        if($link === false){
			            die("ERROR: Could not connect. " . mysqli_connect_error());
			        }

				$sql = "SELECT name FROM students where username = ?";
 
	            	if($stmt = mysqli_prepare($link, $sql))
	            	{
	                	// Bind variables to the prepared statement as parameters
	                	mysqli_stmt_bind_param($stmt, "s", $username);
	                	if(!isset($_SESSION['username']))
	                	{
	                		$message = "Please login first";
                    		echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    		echo "<script>setTimeout(\"location.href = '../login.html';\",1500);</script>";
	                	}
	                
	                	$username = $_SESSION['username'];;
	                
	                	mysqli_stmt_execute($stmt);
	                	$result = mysqli_stmt_get_result($stmt);
						$row = $result->fetch_assoc();
						echo "<p>" . $row['name'] . "</p>";
					}
				?>
				<a href="./profile.html">Profile</a>
				<a href="#">Notifications</a>
				<a href="./project.php">My Projects</a>
				<a href="./progress.php">Progress</a>
			</div>
		</div>
		<div id="content">
			<div class="projectTitle">
				<p>
					About US
				</p>
			</div>
			<p>
				This web portal was create by NS Sushmitha and Sneha Priya as part of a DBMS self study
			</p>
			<p>
				PROject MAnagement System or PROMAS can automate the process of project management. It invites students and guides to become users and communicate solely through the web portal.
			</p>
			<p>
				PROMAS allows students to upload their project documents online and allows teachers to download them from the portal. They can then grade the report and the marks are stored in a secure DB.
			</p>

			<p>
				There is also a functionality for students to send mail to their team members or guides. And guides in turn can send mails to their alloted students.
			</p>
			
			
		</div>
		<div class="footer">
			<p id="copyright">
				&#169Copyrights BMS College of Engineering
			</p>
			<p id="dept">
				Dept. of ISE
			</p>
		</div>
		<script type = "text/javascript" src="./js/home.js"></script>
	</body>
</html>
