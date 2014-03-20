<?php 

require ('function.php');
session_start();
db_connect();

$trainID = ($_POST['t']);
$trainName = ($_POST['tN']); 
$trainType= ($_POST['tT']); 
$numberSb= ($_POST['nSB']); 


if (empty($trainName)) {

	echo "<h4><font color='red'>Request Failed:</font></h4>
	
	<h4><font color='red'>Please enter a valid Train Name.</font></h4>";
    
}
else {

	if ($trainName == $_SESSION['tn']) {

		echo "<h4><font color='red'>Train name has not been changed.</font></h4>";

	}

$insert=sprintf("UPDATE train SET trainName='%s', trainType='%s', numberSb='%s' WHERE trainID ='%s'",
   mysql_real_escape_string($trainName),
    mysql_real_escape_string($trainType),
    mysql_real_escape_string($numberSb),
     mysql_real_escape_string($trainID));
                
                    mysql_query($insert);

                    	// check if number of SB has changed, if it has delete old and generate new ones

                    	if ($numberSb != $_SESSION['nsb']) {

                    			$delete=sprintf("DELETE FROM sandbox WHERE trainID ='%s'",
     									mysql_real_escape_string($trainID));
                
                    					mysql_query($delete);

	                    					for ($i=1; $i<=$numberSb; $i++)
	  										{

	  											
												$insert=("INSERT INTO sandbox (
												`checked` ,
												`trainID`)

												VALUES ('Not checked','$trainID');");

														mysql_query($insert);

											}


                    	} // end if not

                    	unset($_SESSION['tt']);
                    	unset($_SESSION['tn']);
                    	unset($_SESSION['nsb']);
        				


echo "<h4><font color='green'>Train ".$trainName." has been succesfully edited.</font></h4>";

}

?>