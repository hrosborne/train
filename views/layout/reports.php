<?php 
if(isset($_SESSION['valid']) ) { ?>
<h2> Reports and Visualized Data </h2>
<p> Please select a more specific option: </p>
<br>
	<tr><td>
   <a href='?view=sbreports'class='button'>View Data in List Format</a></td>
   <td>	<p class='desc'> - View data by category, staff member, train and in reports.</p> </td>
   <tr><td>	<a href='?view=visual'class='button'>Visualized Reports</a></td>
   <td>	<p class='desc'> - View reports in the format of visualized data - in graphs or pie charts.</p> </td>   	
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php 
} else {
  echo "<br><h3>You must be a registered user to use this site. </h3>  
      <br><h3>Please contact your administrator if you cannot login.</h3>
     <br><br><br>";
} ?>


