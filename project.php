<?php
	session_start();
?>
<!DOCTYPE html>
<html lang = "en-US">
	<head>
		<meta charset = "UTF-8">
		<title>Home</title>
		<link rel = "stylesheet" type = "text/css"  href = "./css/home.css" />
		<link rel = "stylesheet" type = "text/css"  href = "./css/extra.css" />

	</head>
	<body>
		<div id="header">
			<div class="topnav" id="myTopnav">
				<div class="links">
					<a href="./logout.php?logout=1">Logout</a>
					<a href="./about.php">About</a>				
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
	                
	               		$username = $_SESSION['username'];
	               
	               		mysqli_stmt_execute($stmt);
	               		$result = mysqli_stmt_get_result($stmt);
						$row = $result->fetch_assoc();
						echo "<p>" . $row['name'] . "</p>";
					}
				?>
				<a href="./profile.html">Profile</a>
				<a href="./project.php">My Projects</a>
				<a href="./progress.php">Progress</a>
			</div>
		</div>
		<div id="content">
			<div class="pageTitle">
				<p>
					My Projects
				</p>
			</div>
			<p id="projectButton">
					<a href="createProject.php">
						<button class="button createProj">Create New Project</button>
					</a>
					<br>
					<br>
					<div class="dropdown projdropdown">
						<button class="button oldProj">My Projects</button>
						<div class="projdropdown-content">
							<?php
								$link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

							// Check connection
								if($link === false){
								    die("ERROR: Could not connect. " . mysqli_connect_error());
								}

								$sql = "SELECT TeamID FROM students where username = ?";
			 				
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
									$username = $_SESSION['username'];
								
									mysqli_stmt_execute($stmt);
									$result = mysqli_stmt_get_result($stmt);
									$row = $result->fetch_assoc();
									$teamID = $row['TeamID'];
									$teamSQL = "SELECT * FROM team where TeamID = ?";
									if($stmt2 = mysqli_prepare($link, $teamSQL))
					    			{
										// Bind variables to the prepared statement as parameters
										mysqli_stmt_bind_param($stmt2, "i", $teamID);
										$teamID = $row['TeamID'];
										mysqli_stmt_execute($stmt2);
										$result2 = mysqli_stmt_get_result($stmt2);
										$row2 = $result2->fetch_assoc();
										if($row2['ProjectID'] == NULL)
										{
											echo "<p> You have no existing projects</p>";
										}
										else
										{
											
											$projectSQL = "SELECT * FROM projects where ProjectID = ?";
											if($stmt3 = mysqli_prepare($link, $projectSQL))
							    			{
												// Bind variables to the prepared statement as parameters
												mysqli_stmt_bind_param($stmt3, "i", $projID);
												$projID = $row2['ProjectID'];
												mysqli_stmt_execute($stmt3);
												$result3 = mysqli_stmt_get_result($stmt3);
												$row3 = $result3->fetch_assoc();
												echo "<a href=\"#\">" . $row3['ProjectName'] . "</a>";	
											}
										}
									}
								}
							?>
									
						</div>
					</div>
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