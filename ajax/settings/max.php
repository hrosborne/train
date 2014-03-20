<?php

require ('function.php');
session_start();
db_connect();

$addMaxSB = ($_POST['max']);

$insert=sprintf("UPDATE settings SET addMaxSB='%s'",
    mysql_real_escape_string($addMaxSB));
                
                    mysql_query($insert);

                    $_SESSION['maxsb']=$addMaxSB;

echo "<h4><font color='green'>Set max sandbox number to: ".$addMaxSB."</font></h4>";

?>