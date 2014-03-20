<?php

if(isset($_SESSION['valid']) ) {

if ($_SESSION['type'] == "admin")  
{
  
db_connect();

error_reporting(E_ERROR | E_PARSE);

echo"<h1> Engineers Panel </h1>";

	$initialqry = "SELECT * FROM repair WHERE repairedat = '0000-00-00 00:00:00'"; 
	$initialresult = mysql_query($initialqry);


echo"<h3> Unfixed Faults </h3>";

 if(mysql_num_rows($initialresult) == 0) { 

echo "<p>No unfixed faults found. </p>"; ?>

<script>

function engineeraction(url, action) {                                       
switch(action)
{
case 'view':
string= 'action=view'; 
  break;
}                
xmlHttp = new XMLHttpRequest();
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');                               
xmlHttp.onreadystatechange = function() {                                  
if (xmlHttp.readyState == 4) {
     document.getElementById("userresponse").innerHTML=xmlHttp.responseText
    }
}
xmlHttp.send(string);
}   
</script>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
<input value="View fixed faults" type="button" onclick='engineeraction("ajax/eng.php","view")'><br><br><br>
<div id='userresponse'> </div><br><br><br><br><br><br><br><br>

<?php

} else {

// create table
echo "<br><form><div id='dbsetup'><table id='table'>";
echo "<tr><th>Repair #</th><th>Fault Comment</th><th>recorded at</th><th>Train</th><th>SB #</th></tr>";


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
    </td><td><b>".$fault_recorded."</b> 
    </td><td><b>".$fault_train."</b></td>
    <td><b>".$fault_sbname."</b></td></tr>" ; }    ?>

</table><br>

<h4>Select a repair job before pressing report or request.</h4>

<?php echo" <select id='modify'> ";
$qry= "SELECT repairID FROM repair WHERE repairedat = '0000-00-00 00:00:00'"; // make settings
$result = mysql_query($qry);
while($row = mysql_fetch_assoc($result)) {
echo "<option value='".$row['repairID']."'>".$row['repairID']."</option>";
}
echo "</select>"; ?>
    
&nbsp; &nbsp; &nbsp; 

<input value="Report a fault FIXED" type="button"  onclick='engineeraction("ajax/eng.php","repair")'>
<input value="View fixed faults" type="button"  onclick='engineeraction("ajax/eng.php","view")'>

</div></form><br>

<div id='dbsetup'>  <div id="userresponse"> Press a button to carry out an action. </div> </div><br><br>

<script>

function engineeraction(url, action) {                                       

var modify= document.getElementById('modify').value


switch(action)
{

case 'repair':
string= 'action=repair' + '&modify=' + escape(modify); 
  break;

case 'view':
string= 'action=view' + '&modify=' + escape(modify); 
  break;

  case 'repairfix':
 var comment= document.getElementById('repairc').value
 string= 'action=repairfix' + '&comment=' + escape(comment) + '&modify=' + escape(modify); 
  break;

}
                 
xmlHttp = new XMLHttpRequest();
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {

     document.getElementById("userresponse").innerHTML=xmlHttp.responseText

    }

}
xmlHttp.send(string);
}   

</script>


<?php } // else for if no repairs found.

} else { // IF USER DOES NOT HAVE CORRECT ADMIN ACCOUNT ?>

<h1>Engineer Panel</h1>
<br>
<h2> You do not have the correct level of access to view this page. </h2>
<br>
<h2> Please contact your administrator if you have any questions. </h2>
<br><br><br><br><br><br><br><br><br><br><br>
<?php }  



} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

       <br><br>
  <br>
  ";
}





