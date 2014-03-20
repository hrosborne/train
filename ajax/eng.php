<?php

include('function.php');
session_start();
db_connect();

$action= ($_POST['action']); 

switch($action) {

	
	case "repair":
	$modify= ($_POST['modify']); 

	$initialqry = "SELECT * FROM repair WHERE repairID = $modify"; 
	$initialresult = mysql_query($initialqry);

	while($repair = mysql_fetch_assoc($initialresult))
	{
		$sbID= $repair['sbID'];  
	}

	  $qry="SELECT trainID, sbName FROM sandbox WHERE sbID= $sbID";
	  $result=mysql_query($qry);
	   if(mysql_num_rows($result) == 0) { 

		echo "<p>ERROR, cannot find TRAIN </p>";  



	} else {
	  while ($row = mysql_fetch_assoc($result)) {
	    $getTID= $row['trainID'];  
	    $sbname = $row['sbName'];
	 }
	 }

	 


if (isset($getTID)) {

	$qry2="SELECT trainName FROM train WHERE trainID= $getTID";
	 $result2=mysql_query($qry2);
	 while ($row2 = mysql_fetch_assoc($result2)) {
	  $train = $row2['trainName'];
	 }
	  		
	$which = $train.", #".$sbname;

	echo"<h4>Fixed repair report - for ".$which."(Complete when repair is finished)</h4>";
						
	echo"<textarea cols='65' rows= '6' name='repairc' id='repairc'> </textarea>"; ?>

    <input value="Confirm Repair Complete" type="button" onclick='engineeraction("ajax/eng.php","repairfix")'>  <?php
}
	break;


	case "view":
	echo "<h3> Viewing Fixed Faults: </h3>";

	$initialqry = "SELECT * FROM repair WHERE repairedat > '0000-00-00 00:00:00'"; 
	$initialresult = mysql_query($initialqry);

	 if(mysql_num_rows($initialresult) == 0) { 

		echo "<p>No fixed faults found. </p>";  } else {

	// create table
	echo "<br><form><div id='dbsetup'><table id='table'>";
	echo "<tr><th>Repair #</th><th>Fault Comment</th><th>Repair Comment</th><th>Train</th><th>SB #</th></tr>";


	while($repair = mysql_fetch_assoc($initialresult))
	{

	  $sbID = $repair['sbID'];

	  $qry="SELECT trainID, timechecked, sbName FROM sandbox WHERE sbID= $sbID";
	  $result=mysql_query($qry);
	  while ($row = mysql_fetch_assoc($result)) {
	    $getTID= $row['trainID'];  
	    $fault_recorded = $row['timechecked'];
	    $fault_sbname = $row['sbName'];
	  }

	  $qry2="SELECT trainName, userID FROM train WHERE trainID= $getTID";
	  $result2=mysql_query($qry2);
	  while ($row2 = mysql_fetch_assoc($result2)) {
	    $fault_train = $row2['trainName'];
	  }
	  
	   echo "<tr><td><b>".$repair['repairID']."</b>
	    </td><td><b>".$repair['faultc']."</b>
 	    </td><td><b>".$repair['repairc']."</b> 
	    </td><td><b>".$fault_train."</b></td>
	    <td><b>".$fault_sbname."</b></td></tr>" ; }    ?>

	</table><br> <?php

	}

	break;

	

	case "repairfix":
	$repairID= ($_POST['modify']); 
	$repairc= ($_POST['comment']); 
	$repairedby= $_SESSION['name'];


	$insert=sprintf("UPDATE repair SET repairc='%s', repairedby='%s', repairedat=NOW() WHERE repairID ='%s'",
	mysql_real_escape_string($repairc),
	mysql_real_escape_string($repairedby),
	mysql_real_escape_string($repairID));
	
	echo "<h3> Repair confirmed. </h3>";

	mysql_query($insert);
	
	break;

}


?>