<?php
db_connect();
jquery_scripts();
if(isset($_SESSION['valid']) ) {
db_setup_menu();
?>
<br><div id='dbsetup'><form name='change'>
        <h4>Change User-Train Responsibility</h4>
             <label for='input'>Train ID, Name:</label>    
             <select name='TrainUserID' onclick='checktrainuser("ajax/tu.php")'>
        <?php    $qry= "SELECT trainID, trainName FROM train"; // make settings
                    $result = mysql_query($qry);
                     if(mysql_num_rows($result) == 0) { 
                      echo "<option value ='no'>No trains registered. </option>"; } else {              
                       while($row = mysql_fetch_assoc($result)) {

                        echo "<option value='".$row['trainID']."'>".$row['trainID'].", ".$row['trainName']."</option>";

                       }  }?>

                    </select> 
                    <label id='check'></labeL>
                  			

     <?php       echo"<br><br>
              <label for='input'>User ID to register to:</label>
              <select name='ID'>";
              
                  $qry= "SELECT * FROM user"; 
                  $result = mysql_query($qry);
                     while($row = mysql_fetch_assoc($result)) {

                 echo "<option value='".$row['userid']."'>".$row['firstname']; echo" ".$row['surname']; echo ", ID: ".$row['userid']."</option>";
                     
                    }; ?>
     
					 </select> &nbsp; <input value="Make Changes" type="button" onclick='changetrain("ajax/changetrain.php")'> </form> </div> <br>
 
          <div id='dbsetup'> <div id="cloon"> Please press Make Changes to continue. </div> </div> <br><br>


<script>

function checktrainuser(url) {
// construct post data
var form     = document.forms['change'];                            
var name = form.TrainUserID.value;
vars = 'tID=' + escape(name);                              
if (window.XMLHttpRequest) {
request = new XMLHttpRequest();
}
request.open('POST', url, true);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
request.onreadystatechange = function() {                                   
if (request.readyState == 4) {
document.getElementById("check").innerHTML=request.responseText
}
}
request.send(vars);
}


function changetrain(url) {
var form     = document.forms['change'];                            
var name = form.TrainUserID.value;
var id = form.ID.value
vars = 'tID=' + escape(name) + '&ID=' + escape(id);
var xmlHttp = false;
if (window.XMLHttpRequest) {
xmlHttp = new XMLHttpRequest();
}
xmlHttp.open('POST', url, true);
xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlHttp.onreadystatechange = function() {                                  
if (xmlHttp.readyState == 4) {
document.getElementById("cloon").innerHTML=xmlHttp.responseText
}
}
xmlHttp.send(vars);
}
</script>
<?php 
} else {
  echo "<br><h3>You must be a registered user to use this site. </h3>    
      <br><h3>Please contact your administrator if you cannot login.</h3>
       <br><br><br>";  
}

