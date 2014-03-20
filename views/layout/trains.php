<?php
// BUTTONS http://www.cssbuttongenerator.com
db_connect();
jquery_scripts();
if(isset($_SESSION['valid']) ) { 
db_setup_menu();
 
?>
<br><div id='dbsetup'><h4>Add Train</h4><form name ='addtrain'>  

<div id='gap'>							
<label for='input'>Train Name:</label>
<input type='textarea' name='TrainName' id='textarea'>
</div><br>


<div id='gap'>	
<label for='input'>User ID to register to:</label>
<select name='ID'>
<?php 
$qry= "SELECT * FROM user"; 
$result = mysql_query($qry);
while($row = mysql_fetch_assoc($result)) {
echo "<option value='".$row['userid']."'>".$row['firstname']; echo" ".$row['surname']; echo ", ID: ".$row['userid']."</option>";
}  
echo "</select><br> <br> <label for='input'>Type:</label><select name='trainType'>";
$qry= "SELECT * FROM traintypes"; // make settings
$result = mysql_query($qry);
while($row = mysql_fetch_assoc($result)) {
echo "<option value='".$row['trainType']."'>".$row['trainType']."</option>";
}
echo "</select><br> ";

$o=$_SESSION['maxsb']; // get max sb
echo "<br> 
<label for='input'>Number of Sandboxes:</label>
<select name='numberSb'>";

for ($i=1; $i<=$o; $i++)
{
echo"<option value='".$i; echo"'>".$i; echo"</option>";
}						
              
echo"</select></div>"; ?>
       				
<br>       

<label for='input'>Entry time:</label>
<input type='text' id= 'entry'  class='time' style='width: 98px'>
            
<label for='input'>Vacate time:</label>
<input type='text' id='vacate'  class='time' style='width: 98px'>

<br><br>   
        
<label for='input'>Entry Date:</label>
<input type='text' id= 'entryD' name='entryD'  style='width: 98px'>
		
<label for='input'>Vacate Date:</label>
<input type='text' id='vacateD' name='vacateD'  style='width: 98px'>  
<br><br>

<input value="ADD" type="button"  onclick='trainAdd("ajax/addtrain.php")'></form></div><br>
							

<div id='dbsetup'>  <div id="addresponse"> Fill in the fields and click ADD. </div> </div><br>
             

<script>
                     
$(function() {

$('#entry').timepicker({ 'scrollDefaultNow': true });
$('#vacate').timepicker({ 'scrollDefaultNow': true });
});

</script>

<script>

$(function() {
                                  
$( "#entryD" ).datepicker({ minDate: 0, maxDate: "1M" });
$( "#vacateD" ).datepicker({ minDate: 0, maxDate: "7D" });
});  


function trainAdd(url) {
var xmlHttp = false;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlHttp.onreadystatechange = function() {                                
if (xmlHttp.readyState == 4) {
pageUpdate(xmlHttp.responseText);
}
}
xmlHttp.send(getVars());
}

function pageUpdate(str){
document.getElementById("addresponse").innerHTML = str;
}

function getVars() {
var form     = document.forms['addtrain'];                               
var name = form.TrainName.value;
var sb = form.numberSb.value;
var type = form.trainType.value;
var entry = form.entry.value;
var vac = form.vacate.value;
var id = form.ID.value;
var eD = form.entryD.value;
var vD = form.vacateD.value;

vars = 'trainName=' + escape(name) + '&numberSb=' + escape(sb) 
+ '&trainType=' + escape(type) + '&entry=' + escape(entry) + '&vacate=' + escape(vac) 
+ '&ID=' + escape(id) + '&entryD=' + escape(eD) + '&vacateD=' + escape(vD); 

return vars;
}

</script>   


<?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>
