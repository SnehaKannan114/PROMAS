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

                $sql = "SELECT * FROM students where username = ?";
 
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
                $link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

                    // Check connection
                    if($link === false){
                        die("ERROR: Could not connect. " . mysqli_connect_error());
                    }

                $sql = "SELECT * FROM students where username = ?";
 
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
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Username : " . $row['username'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Name : " . $row['name'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">USN : " . $row['USN'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Department : " . $row['department'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Semester : " . $row['semester'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Phone : " . $row['phone'] . "</p>";
                        echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Email : " . $row['email'] . "</p>";
                        $teamID = $row['teamID'];
                        $sql = "SELECT * FROM team where teamID = ?";
 
                        if($stmt2 = mysqli_prepare($link, $sql))
                        {
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt2, "i", $team);
                            $team = $teamID;
                        
                            mysqli_stmt_execute($stmt2);
                            $result2 = mysqli_stmt_get_result($stmt2);
                            $row2 = $result2->fetch_assoc();
                            echo "<p style=\"padding-left:60px;padding-top:20px;font-size:20px\">Team : " . $row2['TeamName'] . "</p>";
                        }
                    }
                ?>
            
        
    </div>
    <script type = "text/javascript" src="./js/home.js"></script>
    </body>
</html>