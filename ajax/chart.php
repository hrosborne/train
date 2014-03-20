<?php

require ('function.php');
db_connect();
$rep= ($_POST['rep']); // report type
require ('gChart.php');

switch($rep) {
// when logout or login is pressed, view intercepts and runs the respective function.
	case "1":

	missedsb();
	exit;	
	break;

	case "2":
	latetrain();
	exit;
	break;

	case "3":
	faultregularity();
	exit;
	break;

	case "4":
	averagesandlevel();
	exit;
	break;
}


function latetrain() {
// checks trains that were not finished checking before they were meant to depart.

$sql = "SELECT vacatet, checkedat, userID FROM train WHERE checkedat > 0 AND checkedat > vacatet";
$result = mysql_query($sql);
$total = (mysql_num_rows($result));
if ($total < 1) {
	echo "There are no trains that have been checked late, or there is not enough data to generate a report.";
} else {

while ($row = mysql_fetch_assoc($result)) {
	$blahsbarray[]=$row['userID'];	
}

$dataset = implode(',', (array_count_values($blahsbarray)));
$sql = 'SELECT surname FROM user WHERE userid IN (' . implode(',', array_map('intval', $blahsbarray)) . ')';
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
	$surnamea[]=$row['surname'];
}	

$ppiChart = new gPieChart(800,350);
$ppiChart->addDataSet(array($dataset));
$ppiChart->setLabels(array($surnamea));
$ppiChart->setLegend(array($surnamea));
$ppiChart->setColors(array("ff3344", "11ff11", "22aacc"));
$surnames = implode(', ', $surnamea);

echo "<h4>This chart shows the number of times each user has been late finishing the sandbox checks for a train.";

echo "<br><br>Late in this case, means that the time at which checks were complete was after the train should have left.</h4>";

echo "<img src="; echo $ppiChart->getUrl(); echo" />";

echo "<br><br>Users Involved: <b>".$surnames."</b>";
echo "<br># of times final checks were late: <b>".$dataset."</b>";

} // end no results

}


function missedsb() {
// chart to show number of occurences where sandbox were completly missed before the train had to depart

$qry = "SELECT DISTINCT userID FROM train WHERE NOW() > vacatet AND checkedat = '0000-00-00 00:00:00' ORDER BY userID";
$result = mysql_query($qry);
$total = (mysql_num_rows($result));

if ($total < 1) {
	echo "No missed sandboxes.";
} else {

while ($row = mysql_fetch_assoc($result)) {
	
	$users[]=$row['userID'];	
}

$missedcount = array();

foreach($users as $id) {

			$sql = "SELECT trainID, vacatet, checkedat FROM train 
			WHERE NOW() > vacatet AND checkedat = '0000-00-00 00:00:00' AND userID = $id";
			$result = mysql_query($sql);

			while ($row = mysql_fetch_assoc($result)) {
				
				$TIDa[]=$row['trainID'];	
			}

			$trains = implode(', ', $TIDa);

			$qry=("SELECT sbID FROM sandbox WHERE trainID IN ({$trains})");
			$result=mysql_query($qry);
				
				while($row = mysql_fetch_assoc($result)) {		
					$sbarray[]=$row['sbID'];		 
				}

			$sblist= implode(',', $sbarray);
						
				$qrySB=("SELECT count(sbID) FROM sandbox WHERE sbId IN ({$sblist}) AND checked = 'Not checked'");			

					$sb_checked_qry = mysql_query($qrySB);

						while($sbrow = mysql_fetch_assoc($sb_checked_qry)) 
						{  	
							$notcheckedassoc = $sbrow;
						}

			if (isset($notcheckedassoc)) {
			   
			foreach ($notcheckedassoc as $key=>$val)
			$notchecked=$val;
			$missedcount[] = $val;
			}	

			echo "<br>User ID: <b>".$id."</b>, Occurance of missed sandboxes after train has left: <b>".$notchecked."</b>";

}

$sql = 'SELECT surname FROM user WHERE userid IN (' . implode(',', array_map('intval', $users)) . ')';
$result = mysql_query($sql);

while ($row = mysql_fetch_assoc($result)) {
	$surnamea[]=$row['surname'];
}	

$barChart = new gBarChart(800,350,'g');

foreach($missedcount as $key => $value) {

		$barChart->addDataSet(array($value));

	}

$barChart->setLegend(array($surnamea));
$barChart->setColors(array("ff3344", "11ff11", "22aacc"));
$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
$barChart->setAutoBarWidth();

echo "<br><br><img src="; echo $barChart->getUrl(); echo" />";

} // end no results

}


function faultregularity() {

$qry = "SELECT sbID, fault_occ FROM fault_occ ORDER BY sbID";
$result = mysql_query($qry);

$total = (mysql_num_rows($result));
if ($total < 1) {
	echo "Not enough data to generate report.";
} else {

while ($row = mysql_fetch_assoc($result)) {
	
	$sb[]=$row['sbID'];	
	$fault[]=$row['fault_occ'];	
}

if (!array_filter($fault)) {
   echo "Not enough data to generate report.";
} else {
  
echo "<h4>Fault Occurance by Sandbox (ID):</h4>";

$barChart = new gBarChart(800,350,'g');
$barChart->addDataSet(array($fault));
$barChart->setLegend(array($sb));
$barChart->setColors(array("ff3344", "11ff11", "22aacc"));
$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
$barChart->setAutoBarWidth();

echo "<br><br><img src="; echo $barChart->getUrl(); echo" />";

echo "<br><br><h4>Fault Occurance by Train (ID):</h4>"; 
$qry= "SELECT
  sandbox.trainID AS id
FROM sandbox
  INNER JOIN fault_occ ON fault_occ.sbID = sandbox.sbID
GROUP BY sandbox.trainID";

$result = mysql_query($qry);

while ($row = mysql_fetch_assoc($result)) {	
	$id[]=$row['id'];		
}

$qry= "SELECT AVG(fault_occ.fault_occ) AS average
FROM sandbox
  INNER JOIN fault_occ ON fault_occ.sbID = sandbox.sbID
GROUP BY sandbox.trainID";

$result = mysql_query($qry);

while ($row = mysql_fetch_assoc($result)) {
	
	$avg2[]=$row['average'];
		
}

$tbarChart = new gBarChart(800,350,'g');
$tbarChart->addDataSet(array($avg2));
$tbarChart->setLegend(array($id));
$tbarChart->setColors(array("ff3344", "11ff11", "22aacc"));
$tbarChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
$tbarChart->setAutoBarWidth();

echo "<br><br><img src="; echo $tbarChart->getUrl(); echo" />";

} // end array not empty

} // end if total > 0

} // end function




function averagesandlevel() {

echo "<h4>Average sandlevels by Sandbox (ID) (scale 1-100):</h4>";

$qry = "SELECT sbID, avg_level FROM fault_occ ORDER BY sbID";
$result = mysql_query($qry);

$total = (mysql_num_rows($result));
if ($total < 1) {
	echo "Not enough data to generate report.";
} else {

while ($row = mysql_fetch_assoc($result)) {
	
	$sb[]=$row['sbID'];	
	$avg[]=$row['avg_level'];	
}

if (!array_filter($avg)) {
   echo "Not enough data to generate report.";
} else {

$barChart = new gBarChart(800,350,'g');
$barChart->addDataSet(array($avg));
$barChart->setLegend(array($sb));
$barChart->setTitle("All Tickets by Issue Type");
$barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
$barChart->setAutoBarWidth();

echo "<img src="; echo $barChart->getUrl(); echo" />";

echo "<br><br><h4>Average sandlevels by Train (ID) (scale 1-100):</h4>"; 
$qry= "SELECT
  sandbox.trainID AS id
FROM sandbox
  INNER JOIN fault_occ ON fault_occ.sbID = sandbox.sbID
GROUP BY sandbox.trainID";

$result = mysql_query($qry);

while ($row = mysql_fetch_assoc($result)) {	
	$id[]=$row['id'];		
}

$qry= "SELECT AVG(fault_occ.avg_level) AS average
FROM sandbox
  INNER JOIN fault_occ ON fault_occ.sbID = sandbox.sbID
GROUP BY sandbox.trainID";

$result = mysql_query($qry);

while ($row = mysql_fetch_assoc($result)) {
	
	$avg2[]=$row['average'];	
	
}

$tbarChart = new gBarChart(800,350,'g');
$tbarChart->addDataSet(array($avg2));
$tbarChart->setLegend(array($id));
$tbarChart->setColors(array("ff3344", "11ff11", "22aacc"));
$tbarChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
$tbarChart->setAutoBarWidth();

echo "<img src="; echo $tbarChart->getUrl(); echo" />";

} // end array not empty

} // end if total > 0

} // end function



?>