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
        
            
            <?php
            /* Attempt MySQL server connection. Assuming you are running MySQL
            server with default setting (user 'root' with no password) */
            $link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

            // Check connection
            if($link === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
         
            //Get current row count   
            $sql = "SELECT * FROM team where TeamID = ?";
 
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $team);
                
                $team =  (int)$_SESSION['guideGradedTeam'];
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = $result->fetch_assoc();
                $teamName = $row['TeamName'];
                
            } else{
                echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
            }

            echo "<h2>Team Name : " . $teamName . "</h2>";
            if(isset($_GET['doc']))
            {
                echo "<h2>Report Type : " . $_GET['doc'] . "</h2";
            }
                //echo '<div class="errormsg"> Error </div>';
                // Set parameters
            // Close connection
            mysqli_close($link);
            ?>
            
            <div class="container">
                <div class="login-box fadeInUp">
                    <div class="box-header">
                        <div class = "login-box-header">Assign Marks</div>
                    </div>
                    <form action="./php/updateMarks.php" method="post">
                        <label for="team_name">Marks</label>
                        <br/>
                        <input type="number" id="marks" name="marks">
                        <br/>
                        <?php
                        echo "<input type='hidden' name='teamID' value=" . $team . "/>
                        <br/>
                        <input type='hidden' name='docType' value='" . $_GET['doc'] . "'/>
                        <br/>";
                        ?>
                        <input type="submit" value="Submit">
                        <br/>
                    </form>
                </div>
            </div>
    <script type = "text/javascript" src="./js/home.js"></script>
    </body>
</html>
