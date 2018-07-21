<?php
    session_start();
?>
<!doctype html>
<html>
    <head>
        <title>My Teams</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="./css/home.css">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        
        <div id="header">
            <div class="topnav" id="myTopnav">
                <div class="links">
                    <a href="./logout.php?logout=1">Logout</a>
                    <a href="#about">About</a>              
                    <a href="#dashboard">Dashboard</a>
                    <a href="./guideHome.php">Home</a>
                    
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

                $sql = "SELECT name FROM guide where username = ?";
 
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
                <a href="./myTeams.php">My Teams</a>
                <a href="./review.php">Review</a>
            </div>
        </div>
        <div id="content">
        
        <div class = 'container'>
        
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
            $sql = "SELECT * FROM team where GuideID = ?";
            if($stmtGetStudents = mysqli_prepare($link, $sql))
            {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmtGetStudents, "i", $guide);
                $guide = $guideID;
                
                mysqli_stmt_execute($stmtGetStudents);
                $result = mysqli_stmt_get_result($stmtGetStudents);
                echo "<table class = 'tasktable' align = 'center'><th>Team</th><th>Synopsis</th><th>ReviewOne</th><th>ReviewTwo</th>";
                while ($row = mysqli_fetch_array($result))
                {
                    $teamID = $row['TeamID'];
                    $teamSQL = "SELECT * FROM team where TeamID = ?";
                    if($stmt2 = mysqli_prepare($link, $teamSQL))
                    {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt2, "i", $team);
                        $team = $teamID;
                        mysqli_stmt_execute($stmt2);
                        $result2 = mysqli_stmt_get_result($stmt2);
                        $row2 = $result2->fetch_assoc();
                        $teamName = $row2['TeamName'];
                        if($row2['ProjectID'] == NULL)
                        {
                            echo "<tr><td>" .  $teamName  . "</td><td colspan = 3>Team has not started project</div>";
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
                                $_SESSION['guideGradedTeam'] = $teamID;

                                echo "<tr><td>" .  $teamName  . "</td>";
                                if($row3['Synopsis'] == NULL)
                                    echo "<td>Not submitted</td>";
                                else
                                {
                                    echo "<td><a style = \"color:gray;text-align:left\" href = " . substr($row3['Synopsis'] , 1) . ">View</a><a style = \"color:red; padding-left:20px;\" href = \"./enterMarks.php?doc=Synopsis\">Grade</a></td>";
                                }
                                if($row3['ReviewOne'] == NULL)
                                    echo "<td>Not submitted</td>";
                                else
                                {
                                    $_SESSION['fileMarks'] = 'ReviewOne';
                                    
                                    echo "<td><a style = \"color:gray;text-align:left\" href = " . substr($row3['ReviewOne'] , 1) . ">View</a><a style = \"color:red; padding-left:20px;\" href = \"./enterMarks.php?doc=ReviewOne\">Grade</a></td>"; 
                                }
                                if($row3['ReviewTwo'] == NULL)
                                    echo "<td>Not submitted</td>";
                                else
                                {
                                    //$_SESSION['fileMarks'] = 'ReviewOne';
                                    
                                    echo "<td><a style = \"color:gray;text-align:left\" href = " . substr($row3['ReviewTwo'] , 1) . ">View</a><a style = \"color:red; padding-left:20px;\" href = \"./enterMarks.php?doc=ReviewTwo\">Grade</a></td>";   
                                }
                            }
                        }
                    }                        

                }
                echo "</table>";
            }
        }
            //echo '<div class="errormsg"> Error </div>';
            // Set parameters
           
        // Close connection
        mysqli_close($link);
        ?>
    </div>
    <script type = "text/javascript" src="./js/home.js"></script>
    </body>
</html>