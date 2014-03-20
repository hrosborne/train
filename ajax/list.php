<?php

require ('function.php');
session_start();
db_connect();

$term = ($_POST['term']);

	$qry = "SELECT * FROM $term"; 
	$result = mysql_query($qry);

switch($term) {

	case "user":

	echo "<form><table id='table'>
	<tr><th>Firstname</th><th>Surname</th><th>User Type</th><th>Modify User</th></tr>";

		// does not need validation as to get to this page this query MUST produce data

		while($row = mysql_fetch_assoc($result))
		{

		$firstname     = $row['firstname'];
		$surname     = $row['surname'];
		$type 		= $row['type'];
 
		   echo "<tr><td style='width: 100px;'><b>".$firstname."</b>
		   </td><td style='width: 100px;'><b>".$surname."</b>
		   </td><td style='width: 80px;'><b>".$type."</b>
		   </td><td style='width: 50px;'><input type='radio' style='width: 50px;' name='modify' value='".$surname."'></input></td></tr>";
		}  

	echo "</table>";
		
	break;

	case "train":

		if(mysql_num_rows($result) == 0) { 

                      echo "No data to be listed."; } else {

	echo "<form><table id='table'>
	<tr><th>ID</th><th>Name</th><th># of SB</th><th>Type</th><th>User responsible</th></tr>";

		while($row = mysql_fetch_assoc($result))
		{

		   echo "<tr><td><b>".$row['trainID']."</b>
		   </td><td><b>".$row['trainName']."</b>
		   </td><td><b>".$row['numberSb']."</b>
		   </td><td><b>".$row['trainType']."</b>
		   </td><td><b>".$row['userID']."</b>
		   </td></tr>";
		}  

	echo "</table>"; }
	
	break;

	case "sandbox":

		if(mysql_num_rows($result) == 0) { 

                      echo "No data to be listed."; } else {

	echo "<form><table id='table'>
	<tr><th>ID</th><th>Checked</th><th>Name</th><th>Sand Level (0-100)</th><th>Defect</th><th>Defect Comment</th><th>of train ID</th></tr>";

	

		while($row = mysql_fetch_assoc($result))
		{

		   echo "<tr><td><b>".$row['sbID']."</b>
		   </td><td><b>".$row['checked']."</b>
		   </td><td><b>".$row['sbName']."</b>
		   </td><td><b>".$row['sbLevel']."</b>
		   </td><td><b>".$row['sbDefect']."</b>
		   </td><td><b>".$row['sbDefectComment']."</b>
		   </td><td><b>".$row['trainID']."</b>
		   </td></tr>";
		}  

	echo "</table>"; }
	
	
	break;

	case "traintypes":

		if(mysql_num_rows($result) == 0) { 

                      echo "No data to be listed."; } else {

	echo "<form><table id='table'>
	<tr><th>ID</th><th>Designation</th><th>Image</th></tr>";

		while($row = mysql_fetch_assoc($result))
		{

		   echo "<tr><td><b>".$row['trainTypeID']."</b>
		   </td><td><b>".$row['trainType']."</b>
		   </td><td><b>".$row['image']."</b>
		   </td></tr>";
		}  

	echo "</table>"; }
	
	break;

	case "repair":

	if(mysql_num_rows($result) == 0) { 

                      echo "No data to be listed."; } else {

	echo "<form><table id='table'>
	<tr><th>ID</th><th>Train ID</th><th>Sandbox ID</th><th>Problem Comment</th><th>Repair Comment</th><th>Repaired By</th><th>On</th></tr>";

		while($row = mysql_fetch_assoc($result))
		{

		   echo "<tr><td><b>".$row['repairID']."</b>
		   </td><td><b>".$row['trainID']."</b>
		   </td><td><b>".$row['sbID']."</b>
		   </td><td><b>".$row['problemc']."</b>
		   </td><td><b>".$row['repairc']."</b>
		   </td><td><b>".$row['repairedby']."</b>
		   </td><td><b>".$row['on']."</b>
		   </td></tr>";
		}  
	

	echo "</table>"; }
	break;

}




?>