<?php

db_connect();

jquery_scripts();

if(isset($_SESSION['valid']) ) {

db_setup_menu();

?>

<br><div id='dbsetup'><form name'setupschedule'>

<h4>Setup Schedule</h4>
             
<label for='input'>Select train (ID, name):</label>
         
<select id='tIDs'>

<?php    $qry= "SELECT trainID, trainName FROM train"; // make settings
         $result = mysql_query($qry);

        	 if(mysql_num_rows($result) == 0) { 
				echo "<option value='no'>No trains registered. </option> </select> <br><br> </div> <br><br><br><br><br>"; 

				} else {

                while($row = mysql_fetch_assoc($result)) {

                echo "<option value='".$row['trainID']."'>".$row['trainID'].", ".$row['trainName']."</option>";

                } ?>
</select>  
                  
&nbsp; &nbsp; &nbsp;   <input value='Lookup' type='button' onclick='schedule("ajax/schedule.php","check")'> </form> </div><br>

<div id='dbsetup'><div id='schedule'> Press Lookup to continue. </div> </div><br><br><br><br>

<?php } ?>

<script>
                      
function schedule(url, form) {

var tid = document.getElementById('tIDs').value   

switch(form)
{

case 'check':                   
string= 'action=check' + '&tID=' + escape(tid);
break;

case 'apply':    

var sch = document.getElementById('sch').value 
var e = document.getElementById('entry').value 
var ed = document.getElementById('entryD').value 
var v = document.getElementById('vacate').value 
var vd = document.getElementById('vacateD').value 

string= 'action=apply' + '&tID=' + escape(tid) 
+ '&sch=' + escape(sch)+ '&e=' + escape(e) 
+ '&ed=' + escape(ed)+ '&v=' + escape(v)+ '&vd=' + escape(vd);

break;

case 'schedule':                   
string= 'action=schedule' + '&tID=' + escape(tid);
break;

case 'schedule2':                    
string= 'action=schedule2' + '&tID=' + escape(tid);
break;

}
             
var xmlHttp = false;

if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}

xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {

	switch(form)
		{

		case 'check':

		                     
		document.getElementById("schedule").innerHTML=xmlHttp.responseText

		break;

		case 'apply':                   
		document.getElementById("confirm").innerHTML=xmlHttp.responseText
		break;


		case 'schedule':
		                     
		document.getElementById("schedule").innerHTML=xmlHttp.responseText

		$( "#entryD" ).datepicker({ minDate: 0, maxDate: "1M" });
		$( "#vacateD" ).datepicker({ minDate: 0, maxDate: "7D" });
		$('#entry').timepicker({ 'scrollDefaultNow': true });
		$('#vacate').timepicker({ 'scrollDefaultNow': true });
		
		break;

		case 'schedule2':
		                      
		document.getElementById("schedule").innerHTML=xmlHttp.responseText

		$( "#entryD" ).datepicker({ minDate: 0, maxDate: "1M" });
		$( "#vacateD" ).datepicker({ minDate: 0, maxDate: "7D" });
		$('#entry').timepicker({ 'scrollDefaultNow': true });
		$('#vacate').timepicker({ 'scrollDefaultNow': true });

		break;

		}

	}
}
xmlHttp.send(string);
}

</script>

<?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>