<?php

include('function.php');
session_start();
db_connect();

$tid = ($_POST['tID']); 
$uid = ($_POST['ID']);

			$update="UPDATE  `train` SET  `userID` =  $uid WHERE  `train`.`trainID` =$tid";

			if ($tid == 'no') {

				echo "No changes made, as no trains are registered.";
			} else {

       	mysql_query($update);

     echo "<h3><font color='green'>Success: Updated Train ".$tid." with User ".$uid."</font></h3>"; }

 ?>