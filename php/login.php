<!doctype html>
<html>
    <head>
    </head>
    <body>
        
        <div class = 'container'>
        
        <?php
        session_start();
        /* Attempt MySQL server connection. Assuming you are running MySQL
        server with default setting (user 'root' with no password) */
        $link = mysqli_connect("localhost", "root", "", "PROMAS_DB");        

        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
         
            //Get current row count   
            $sql = "SELECT * FROM users where username = ? and passwd = ? ";
 
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $username, $passwd);
                
                $username = $_REQUEST['username'];
                $passwd = $_REQUEST['password'];
                
                //echo $username . $passwd ;
                // Attempt to execute the prepared statement
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                //echo mysqli_num_rows($result);
                if(mysqli_num_rows($result) > 0){
                    $row = $result->fetch_assoc();
		            $_SESSION['usertype'] = $row['type'];
                    $_SESSION['username'] = $username;
                    $message = 'Login Successful';
                    echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
		            if($_SESSION['usertype'] == 3)
                        echo "<script>setTimeout(\"location.href = '../index.php';\",1500);</script>";
                    else
                        echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
                } else{
                    $message = "Invalid Credentials";
                    echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    echo "<script>setTimeout(\"location.href = '../loginPage.html';\",1500);</script>";
                }
            } else{
                echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
            }

            
        // Close connection
        mysqli_close($link);
        ?>
    </div>
    </body>
</html>
