<?php

session_start();
$target_dir = "../uploads/";
$target_file = $target_dir . basename(preg_replace('/\s+/', '_', $_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an valid - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not valid.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "docx" && $imageFileType != "pdf" ) {
    echo "Sorry, only PDF and DOCX files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
    {
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
			echo $teamID;
			$teamSQL = "SELECT * FROM team where teamID = ?";
			if($stmt2 = mysqli_prepare($link, $teamSQL))
			{
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt2, "i", $teamID);
				$teamID = $row['TeamID'];
				mysqli_stmt_execute($stmt2);
				$result2 = mysqli_stmt_get_result($stmt2);
				$row2 = $result2->fetch_assoc();
				if($_REQUEST['typeOfFile'] == 'Synopsis')
				{	$projectSQL = "UPDATE projects set Synopsis = ?  where ProjectID = ?";
					if($stmt3 = mysqli_prepare($link, $projectSQL))
					{
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt3, "si", $pathname, $projID);
						$projID = $row2['ProjectID'];
						$pathname = $target_file;
						if(mysqli_stmt_execute($stmt3))
						{
							$message = "Uploaded the file" . basename( $_FILES["fileToUpload"]["name"]);
                    		echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    		echo "<script>setTimeout(\"location.href = '../index.php';\",1500);</script>";
						}
						
					 }
				}
				else if($_REQUEST['typeOfFile'] == 'ReviewOne')
				{	$projectSQL = "UPDATE projects set ReviewOne = ?  where ProjectID = ?";
					if($stmt3 = mysqli_prepare($link, $projectSQL))
					{
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt3, "si", $pathname, $projID);
						$projID = $row2['ProjectID'];
						$pathname = $target_file;
						if(mysqli_stmt_execute($stmt3))
						{
							$message = "Uploaded the file" . basename( $_FILES["fileToUpload"]["name"]);
                    		echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    		echo "<script>setTimeout(\"location.href = '../index.php';\",1500);</script>";
						}
						
					 }
				}
				else if($_REQUEST['typeOfFile'] == 'ReviewTwo')
				{	$projectSQL = "UPDATE projects set ReviewTwo = ?  where ProjectID = ?";
					if($stmt3 = mysqli_prepare($link, $projectSQL))
					{
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt3, "si", $pathname, $projID);
						$projID = $row2['ProjectID'];
						$pathname = $target_file;
						if(mysqli_stmt_execute($stmt3))
						{
							$message = "Uploaded the file" . basename( $_FILES["fileToUpload"]["name"]);
                    		echo "<script type='text/javascript'>var conf = confirm('$message');</script>";  
                    		echo "<script>setTimeout(\"location.href = '../index.php';\",1500);</script>";
						}
						
					 }
				}		
			}		
		}

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
