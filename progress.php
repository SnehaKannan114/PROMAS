<?php
	session_start();
?>
<!DOCTYPE html>
<html lang = "en-US">
	<head>
		<meta charset = "UTF-8">
		<title>Progress</title>
		<link rel = "stylesheet" type = "text/css"  href = "./css/home.css"/>
		<link rel = "stylesheet" type = "text/css"  href = "./css/style.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div id="header">
			<div class="topnav" id="myTopnav">
				<div class="links">
					<a href="./logout.php?logout=1">Logout</a>
					<a href="#">About</a>				
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
					My Progress
				</p>
			</div>
			<div class="container-fluid">
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
								echo "<div class=\"row\">
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Synopsis</h></div>
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Review One</h3></div>
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Review Two</h3></div>
							  	</div>
			  						<div class=\"row\">
				    				<div class=\"col-sm-4\"><div class=\"completedBtn\">No Project</div></div>
				    				<div class=\"col-sm-4\"><div class=\"completedBtn\">No Project</div></div>
				    				<div class=\"col-sm-4\"><div class=\"completedBtn\">No Project</div></div>
				  				</div>";
								
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
									echo "<div class=\"row\">
							    	<div class=\"col-sm-12\"><h3 style=\"text-align: center\">" . $row3['ProjectName'] . "</h></div>
									</div>";	
									echo "<div class=\"row\">
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Synopsis</h></div>
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Review One</h3></div>
							    	<div class=\"col-sm-4\"><h3 style=\"text-align: center\">Review Two</h3></div>
							  		</div>";
							  		echo "<div class=\"row\">";
							  		if($row3['Synopsis'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\">Incomplete</div></div>";
							  		}
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\" style=\"background-color:green;\">Complete</div></div>";
							  		}	
							  		if($row3['ReviewOne'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\">Incomplete</div></div>";
							  		}
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\" style=\"background-color:green;\">Complete</div></div>";
							  		}
							  		if($row3['ReviewTwo'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\">Incomplete</div></div>";
							  		}	
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"completedBtn\" style=\"background-color:green;\">Complete</div></div>";
							  		}
							  		echo "</div>";

							  		echo "<div class=\"row\">";
							  		if($row3['Synopsis'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"submitFile center-block\"><form enctype=\"multipart/form-data\" action=\"./php/fileHandler.php\" method=\"POST\">
											  <fieldset>
											    <legend>Upload now</legend>
											    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
											    <br>
											    <input type='hidden' name='typeOfFile' value='Synopsis'/>
											    <input type=\"submit\" value=\"submit\">
											    <hr>
											  </fieldset>
											</form></div></div>";
							  		}
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\">
							  			<div class=\"center-block link\">
							  			<a style = \"color:gray;margin-left:140px;\" href = " . substr($row3['Synopsis'] , 1) . ">View Synopsis</a>
							  			</div>
							  			</div>";
							  		}	
							  		if($row3['ReviewOne'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"submitFile center-block\"><form enctype=\"multipart/form-data\" action=\"./php/fileHandler.php\" method=\"POST\">
											  <fieldset>
											    <legend>Upload now</legend>
											    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
											    <br>
											    <input type='hidden' name='typeOfFile' value='ReviewOne'/>
											    <input type=\"submit\" value=\"submit\">
											    <hr>
											  </fieldset>
											</form></div></div>";
							  		}
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\">
							  			<div class=\"center-block link\">
							  			<a style = \"color:gray;margin-left:140px;\" href = " . substr($row3['ReviewOne'] , 1) . ">View Review</a>
							  			</div>
							  			</div>";
							  		}
							  		if($row3['ReviewTwo'] == NULL)
							  		{
							  			echo "<div class=\"col-sm-4\"><div class=\"submitFile center-block\"><form enctype=\"multipart/form-data\" action=\"./php/fileHandler.php\" method=\"POST\">
											  <fieldset>
											    <legend>Upload now</legend>
											    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
											    <br>
											    <input type='hidden' name='typeOfFile' value='ReviewTwo'/>
											    <input type=\"submit\" value=\"submit\">
											    <hr>
											  </fieldset>
											</form></div></div>";
							  		}	
							  		else
							  		{
							  			echo "<div class=\"col-sm-4\">
							  			<div class=\"center-block link\">
							  			<a style = \"color:gray;margin-left:140px;\" href = " . substr($row3['ReviewTwo'] , 1) . ">View Review</a>
							  			</div>
							  			</div>";
							  		}
							  		echo "</div>";
							  		
								}
							}
						}
					}
				?>
			</div>
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
