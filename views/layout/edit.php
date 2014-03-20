<?php

db_connect();

jquery_scripts();

if(isset($_SESSION['valid']) ) {

db_setup_menu();

?>

<br><div id='dbsetup'><form name='ed'>

<h4>Edit/Delete Train</h4>

<label for='input'>Train ID, Name:</label>
         
<select name='trainID' id='trainIDedit' onclick='ED("ajax/ed.php")'> 

<?php  $qry= "SELECT trainID, trainName FROM train"; // make settings
       $result = mysql_query($qry);

        if(mysql_num_rows($result) == 0) { 

                      echo "<option value ='no'>No trains registered. </option> </select>  "; } else {

                       while($row = mysql_fetch_assoc($result)) {

                        echo "<option value='".$row['trainID']."'>".$row['trainID'].", ".$row['trainName']."</option>";
                       }
                      
echo "</select>";   ?> 

&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <label for='input'>Delete or Edit</label>
<select name='chart' id='ed' onclick='ED("ajax/ed.php")'>
<option value='1'>Edit</option>
<option value='0'>Delete</option>
</select> <br> <?php } ?> </form> <br> </div> <br><br><br>

<?php
        if(mysql_num_rows($result) == 0) { 

        } else {
        	echo "<div id='dbsetup'> <div id='edupdate'> Please click a drop down box to continue. </div> </div><br><br>";
        }     ?>                       

<script>

function del(url) {
                                             
var id= document.getElementById('trainIDedit').value

blahvar= 'a=' + escape(id);

if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}

xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {
document.getElementById('edupdate').innerHTML=xmlHttp.responseText
}
}
xmlHttp.send(blahvar);
}   


function edit(url) {
// define post data 
var data = document.getElementById('TrainName').value
var data2 = document.getElementById('trainType').value
var data3 = document.getElementById('numberSb').value
var data4 = document.getElementById('trainIDedit').value
                                                   
editvars= 'tN=' + escape(data) + '&tT=' + escape(data2) + '&nSB=' + escape(data3) + '&t=' + escape(data4);
                        
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}

xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {
document.getElementById('editupdate').innerHTML=xmlHttp.responseText
}

}

xmlHttp.send(editvars);
}   


function ED(url) {

// define post data 
var data = document.getElementById('trainIDedit').value
var data2 = document.getElementById('ed').value
                          
v='tID=' + escape(data) + '&ed=' + escape(data2);

if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}

xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                
xmlHttp.onreadystatechange = function() {
                                   
if (xmlHttp.readyState == 4) {
document.getElementById("edupdate").innerHTML=xmlHttp.responseText
}
}
xmlHttp.send(v);
}

</script>  

<?php 

} else {

  echo "<br><h3>You must be a registered user to use this site. </h3>
     
      <br><h3>Please contact your administrator if you cannot login.</h3>

     <br><br><br>";
} ?>
