<?php 

require ('function.php');
session_start();
db_connect();

$apphead = ($_POST['head']);
$appcontent = ($_POST['cont']); 


if (empty($apphead) && ($appcontent)) {

	echo "<h4><font color='red'>You have not set the header or content.</font></h4>";
	
    
}
else {

	

$insert=sprintf("UPDATE news SET apphead='%s', appcontent='%s' WHERE newsid ='1'",
   mysql_real_escape_string($apphead),
    mysql_real_escape_string($appcontent));
                
                    mysql_query($insert);

echo "<h4><font color='green'>App welcome message set.</font></h4>";

}

?>