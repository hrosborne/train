<?php

require ('function.php');
session_start();
db_connect();

$trainID = ($_POST['a']); 

// check if ID is valid

$check=sprintf("SELECT trainID FROM train WHERE trainID ='%s'",
     mysql_real_escape_string($trainID));
                
              	$result= mysql_query($check);

	if(mysql_num_rows($result)== 0){ 

		echo "<h4><font color='red'>Train has already been deleted.</font></h4>";

	}
	else {

			$delete=sprintf("DELETE FROM train WHERE trainID ='%s'",
     mysql_real_escape_string($trainID));
                
                    mysql_query($delete) or die('There has been a problem connecting to the DB. Your changes are not saved.');


                    	$delete=sprintf("DELETE FROM sandbox WHERE trainID ='%s'",
     						mysql_real_escape_string($trainID));
                
                    				mysql_query($delete) or die('There has been a problem connecting to the DB. Your changes are not saved.');

                   							 echo "<h4><font color='green'>Train with ID of ".$trainID." has been deleted.</font></h4>";

	}

?>