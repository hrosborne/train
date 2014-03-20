<?php 

require ('function.php');
session_start();
db_connect();

$login = ($_POST['message']);
$newsid = 1;


if (empty($login)) {

	echo "<h4><font color='red'>You have not set a login message.</font></h4>";
	
    
}
else {

	

$insert=sprintf("UPDATE news SET login='%s' WHERE newsid ='%s'",
    mysql_real_escape_string($login),
    mysql_real_escape_string($newsid));
                
                    mysql_query($insert);

echo "<h4><font color='green'>App login message has been updated.</font></h4>";

}

?>