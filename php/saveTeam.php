<?php
	session_start();
?>
<html>
<head>
</head>
<body>
<?php
	/* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        $link = mysqli_connect("localhost", "root", "", "PROMAS_DB");
         
        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM guide where username = ?";
        if($stmtGetUser = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmtGetUser, "s", $username);
            $username = $_SESSION['username'];
            mysqli_stmt_execute($stmtGetUser);
            $result = mysqli_stmt_get_result($stmtGetUser);
            $rowGuide = mysqli_fetch_array($result);
            $guideID = $rowGuide['GuideID'];
            $sql = "UPDATE team set GuideID = ? WHERE TeamName = ?";
            if($stmtsetGuide = mysqli_prepare($link, $sql))
            {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmtsetGuide, "is", $guide, $team);
                $guide = $guideID;
                $team = $_REQUEST['team_name'];
                mysqli_stmt_execute($stmtsetGuide);
                if(mysqli_affected_rows($link) == 1)
                {
                	$message = "Added " . $team . " to your teams";
                    echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
                }
                else
                {
                	$message = "Team does not exist";
                    echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
                }
                
            }
        }
            //echo '<div class="errormsg"> Error </div>';
            // Set parameters
           
        // Close connection
        mysqli_close($link);
        ?>
    
</body>
</html>
