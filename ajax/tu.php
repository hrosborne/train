<?php

require ('function.php');
session_start();

db_connect();

$id = ($_POST['tID']); 

$qry= "SELECT userID FROM train WHERE trainID = $id"; 

         $result = mysql_query($qry);

          if(mysql_num_rows($result) == 0) { 

          		// blank response, a response would make no sense

                       } else {
                    
       while($row = mysql_fetch_assoc($result)) {

       	$uid = $row['userID']; }

       	$qry= "SELECT userID FROM user WHERE userID = '$uid'"; 
       		$result = mysql_query($qry);

				if(mysql_num_rows($result) == 0) { 

					echo " - registered to deleted user: ".$uid;   		
				} else {
			
      echo " - currently registered to ID: ".$uid;  
      }
  

}
                             
?>