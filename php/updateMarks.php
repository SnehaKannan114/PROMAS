<?php
    session_start();
?>
<html>
<head>
</head>
<body>
    <?php

    //phpinfo();
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    $link = mysqli_connect("localhost", "root", "", "PROMAS_DB");

    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
     
    //To get project ID
    $teamSQL = "SELECT * FROM team where TeamID = ?";
    if($stmt2 = mysqli_prepare($link, $teamSQL))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt2, "i", $teamID);
        $teamID = $_REQUEST['teamID'];

        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $row2 = $result2->fetch_assoc();
        $projID = $row2['ProjectID'];
    }        
    else
    {
        echo "Could not prepare statement";
    }                                
                                  
    $doctype = $_REQUEST['docType'];
    if($doctype == 'Synopsis')
    // Prepare an insert statement
    {
        $sql = "UPDATE projects set SynopsisMarks = ? where ProjectID =  ?";
     
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $marks, $projid);
            
            $projid = $projID;
            $marks = $_REQUEST['marks'];
            
            // Attempt to execute the prepared statement
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($link) > 0)
            {
                $message = "Updated Marks for Synopsis";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            }
            else
            {
                $message = "Failed : Cannot update marks";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            } 
            
        } 
        else
        {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
        }
          
        // Close statement
        mysqli_stmt_close($stmt);
    }
    else if($doctype == 'ReviewOne')
    // Prepare an insert statement
    {
        $sql = "UPDATE projects set Review1Marks = ? where ProjectID =  ?";
     
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $marks, $projid);
            
            $projid = $projID;
            $marks = $_REQUEST['marks'];
            
            // Attempt to execute the prepared statement
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($link) > 0)
            {
                $message = "Updated Marks for Review One";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            }
            else
            {
                $message = "Failed : Cannot update marks";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            } 
            
        } 
        else
        {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
        }
          
        // Close statement
        mysqli_stmt_close($stmt);
    }

    else if($doctype == 'ReviewTwo')
    // Prepare an insert statement
    {
        $sql = "UPDATE projects set Review2Marks = ? where ProjectID =  ?";
     
        if($stmt = mysqli_prepare($link, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ii", $marks, $projid);
            
            $projid = $projID;
            $marks = $_REQUEST['marks'];
            
            // Attempt to execute the prepared statement
            mysqli_stmt_execute($stmt);
            if(mysqli_affected_rows($link) > 0)
            {
                $message = "Updated Marks for Review Two";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            }
            else
            {
                $message = "Failed : Cannot update marks";
                echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                echo "<script>setTimeout(\"location.href = '../guideHome.php';\",1500);</script>";
            } 
            
        } 
        else
        {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
        }
          
        // Close statement
        mysqli_stmt_close($stmt);
    }

    
    // Close connection
    mysqli_close($link);

    ?>    
</body>
</html>
