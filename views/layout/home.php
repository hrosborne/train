<style>

#news h3 {

font-color: gray;
	

}

</style>


<?php

if (isset($_SESSION['name'])) {
	
	// get news
	db_connect();
   	$qry = "SELECT * FROM news"; 
	$result = mysql_query($qry);

		if($result === FALSE) {
		    die(mysql_error('Error, database not setup correctly.')); 
		}

		
echo "<div id='news'>";

			while($row = mysql_fetch_assoc($result))
			{


   echo "<br><h4>News #".$row['newsid']."</h4>
   <h4>".$row['header']."</h4>
   		<h4>".$row['content']."</h4>";
}  

echo "<br></div>";
	
}
else
{
	echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

       <br><br>
	<br>
	";
}
 
?>

			