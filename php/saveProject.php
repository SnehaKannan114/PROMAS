<html>
<head>
</head>
<body>
<?php
	session_start();
	$link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

	// Check connection
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$sql = "INSERT INTO projects (ProjectID, ProjectName, Subject) VALUES (?, ?, ?)";
                 
        if($stmtinsert = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmtinsert, "iss", $projId, $projName, $subj);
                    
            $result = $link->query("SELECT * FROM projects");
            $rows = mysqli_num_rows($result);
            $projId = $rows + 1;
            $projName = $_REQUEST['proj_name'];
            $subj = $_REQUEST['sub'];
                    
                    // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmtinsert))
            {
            	$sql = "SELECT teamID FROM students where username = ?";
			 	if($stmt = mysqli_prepare($link, $sql))
				{
					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $username);
					$username = $_SESSION['username'];
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);
					$row = $result->fetch_assoc();
					$TeamID = $row['teamID'];
					$teamSQL = "SELECT * FROM team where teamID = ?";
					if($stmt2 = mysqli_prepare($link, $teamSQL))
					{
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt2, "i", $teamID);
						$teamID = $row['teamID'];
						mysqli_stmt_execute($stmt2);
						$result2 = mysqli_stmt_get_result($stmt2);
						$row2 = $result2->fetch_assoc();
						if($row2['ProjectID'] == NULL)
						{
							$sql = "UPDATE team set ProjectID = ? where teamID = ?";
							if($updation = mysqli_prepare($link, $sql))
							{
								// Bind variables to the prepared statement as parameters
								mysqli_stmt_bind_param($updation, "ii", $projID2, $teamID2);
								$teamID2 = $TeamID;
								$projID2 = $projId;
								if(mysqli_stmt_execute($updation))
								{
			                        $message = "Created New Project";
                    				echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    				echo "<script>setTimeout(\"location.href = '../index.php';\",1500);</script>";
			                    } 
			                    else
			                    {
			                        echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
			                    }

							}			
						}
					}
				}      
            } 
            else
            {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
            }
        }

	

?>
    
</body>
</html>
