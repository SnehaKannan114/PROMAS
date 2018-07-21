<?php
   if(isset($_POST['submit']))
   {
   	 echo "File is valid, and was successfully uploaded.\n";
    //Do all the submission part or storing in DB work and all here
    header('Location: whateverpath.php');
   }
   else
	echo "File NOT uploaded.\n";
?>
