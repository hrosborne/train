<?php 

require ('function.php');
session_start();
db_connect();

$id = ($_POST['tID']); 
$ed= ($_POST['ed']); 


if ($ed == 1) {

	 // EDIT

	echo"<h4>Editing: ID ".$id.".<br><br> Current data set is indicated inside the name box, or next to type and number.</h4>";

	$qry = "SELECT trainName, trainType, numberSb FROM train WHERE trainID = $id"; // make settings
    $result = mysql_query($qry);
        while($row = mysql_fetch_assoc($result)) {

        	$_SESSION['tt']= $row['trainType'];
        	$_SESSION['tn']= $row['trainName'];
        	$_SESSION['nsb']= $row['numberSb'];

        }

	
	echo"<form id='edit'>

	<input type='hidden' name='hidden' id='hiddentrain' value='".$id."'>
	
	<label for='input'>Train Name:</label>
	<input type='textarea' id='TrainName' value='".$_SESSION['tn']."'>
							
            
    <label for='input'>Type:</label>
    <select id='trainType'>";
    $qry= "SELECT * FROM traintypes"; // make settings
    $result = mysql_query($qry);
        while($row = mysql_fetch_assoc($result)) {

           	echo "<option value='".$row['trainType']."'>".$row['trainType']."</option>";

        }
                      
    echo "</select> is currently: ".$_SESSION['tt']."";
         
    $numberofSb=10; // make settings

                echo "<br><br>
                        <label for='input'>Number of Sandboxes:</label>
                      <select id='numberSb'>";

                for ($i=1; $i<=$numberofSb; $i++)
                  {
            
        		         echo"<option value='".$i; echo"'>".$i; echo"</option>";
                  }						
                           
                print"</select> is currently: ".$_SESSION['nsb']."<br>"; ?>

				<input value='Confirm' type='button' onclick='JavaScript:edit("ajax/edit.php")'>

				</form> <br><br> <h4 id='editupdate'> </h4>
		
<?php	

}
else {

	// DELETE

	$qry="SELECT * FROM train WHERE trainID= $id AND vacatet >= CurDate()";

	$result= mysql_query($qry);

	if(mysql_num_rows($result)== 0){ 

	$qry="SELECT * FROM train WHERE trainID= $id";
	$result= mysql_query($qry);
	
	echo "<h4><font color='green'>The train selected is not registered in the schedule.</font></h4>

	<h4>Are you sure you wish to delete the train? </h4>"; ?> 


		&nbsp&nbsp<input value='YES' type='button' onclick='JavaScript:del("ajax/delete.php")'> &nbsp&nbsp
				<input value='NO' type='button' onclick="window.location='index.php';" /> 
		<br>
		
		<div id='delete'> </div>


<?php 
	
	

	} else
	{
		echo "<h4><font color='red'>The train selected has yet to complete its schedule. Cannot be deleted.</font></h4>";
	}


	
}

?>

