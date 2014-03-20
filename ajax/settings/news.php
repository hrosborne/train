<?php

require ('function.php');
session_start();
db_connect();

$header = ($_POST['head']);
$content = ($_POST['cont']); 
$newsid= ($_POST['numb']); 



if (empty($header) && ($content)) {

	echo "<h4><font color='red'>You have not set the header or content.</font></h4>";
	
    
}
else {

	

$insert=sprintf("UPDATE news SET header='%s', content='%s' WHERE newsid ='%s'",
   mysql_real_escape_string($header),
    mysql_real_escape_string($content),
    mysql_real_escape_string($newsid));
                
                    mysql_query($insert);

echo "<h4><font color='green'>News number ".$newsid." has been updated.</font></h4>";

}

?>
