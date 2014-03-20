<?php
include('function.php');
session_start();
db_connect();

// validation

$formvalue = array('trainName', 'entry', 'vacate', 'entryD', 'vacateD');	

foreach($_POST AS $key => $value)
{
	if(in_array($key, $formvalue) && $value == '')
	{
		$missed[] = "<h4><font color='red'>$key is required.</font></h4>";
	}	     
}

if (isset($missed)) {

	echo "<h4><font color='red'>Cannot add train, please enter missing data.</font></h4>";
	 
		    foreach($missed as $missed)
		    {
		        echo $missed;
		    }	  	     
	}

$trainName= ($_POST['trainName']); 

if (strlen($trainName) >= 11) {
	echo "<h4><font color='red'>Train name must be less than 12 characters.</font></h4>";
}

if ((isset($missed)) || (strlen($trainName) >= 11))  { }
else {

$numberSb = ($_POST['numberSb']); 
$trainType = ($_POST['trainType']); 
$userID = ($_POST['ID']);

$e = ($_POST['entry']); // entry time
$v = ($_POST['vacate']); // vacate time

$entryTime  = date("H:i:s", strtotime($e)); // formatted time
$vacateTime  = date("H:i:s", strtotime($v)); 


$ed =($_POST['entryD']); // dates
$vd =($_POST['vacateD']);

$edf = date("Y-m-d", strtotime($ed)); // formatted dates
$vdf = date("Y-m-d", strtotime($vd));

$entryt = $edf." ".$entryTime; // combine date and time
$vacatet = $vdf." ".$vacateTime;	

$checkname="SELECT trainName FROM train WHERE trainName = '$trainName'";
$nameresult = mysql_query($checkname); 
if(mysql_num_rows($nameresult) > 0){ 

	echo"<h4><font color='red'>Please use a different Train Name</font></h4>"; 

} 
else { 

$addt=("INSERT INTO  `09034276`.`train` (
`trainID` ,
`trainName` ,
`numberSb` ,
`trainType` ,
`userID` ,
`entryt`,  
`vacatet`)

VALUES (NULL ,  '$trainName',  '$numberSb',  '$trainType', '$userID', '$entryt', '$vacatet');");
		
mysql_query($addt) or die('Query1 DIED');


$qry="SELECT trainID FROM train ORDER BY trainID DESC LIMIT 1"; 
$result = mysql_query($qry); 
while($row = mysql_fetch_assoc($result)) {
$trainID=$row['trainID'];
}


$o=$numberSb;

for ($i=1; $i<=$o; $i++)
  {

$insert=("INSERT INTO  `09034276`.`sandbox` (
`sbName` ,
`checked` ,
`trainID`)

VALUES ('$i', 'Not checked', '$trainID');");

			mysql_query($insert) or die('query2 DIED');

}					
					
					echo "<h4><font color='green'> Database updated with train: ".$trainName; echo".</font></h4>";

					echo "<h4> Last 5 trains added: </h4>";

					$qry="SELECT trainID, trainName, numberSb, trainType FROM train ORDER BY trainID DESC LIMIT 5";

					$result = mysql_query($qry);

					echo"<table id='table'><thead><th scope='col'>Train ID</th><th scope='col'>TrainName</th><th scope='col'>Number of Sandbox</th><th scope='col'>TrainType</th></thead><tbody>";
					
					while($row = mysql_fetch_assoc($result)) {

							
							echo "<tr><td><b>".$row['trainID']."</b>
   										</td><td><b>".$row['trainName']."</b>
   										</td><td><b>".$row['numberSb']."</b>
  										 </td><td>".$row['trainType']."</td></tr>";
								}  

							echo "</tbody></table>";
	
}

}


?>